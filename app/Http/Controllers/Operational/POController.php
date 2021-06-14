<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Ticket;
use App\Models\TicketVendor;
use App\Models\Po;
use App\Models\POUploadRequest; 
use App\Models\PoAuthorization;
use App\Models\Authorization; 
use PDF;
use DB;
use Storage;
use Mail;
use App\Mail\POMail;


class POController extends Controller
{
    public function poView(){
        $salespoint_ids = Auth::user()->location_access->pluck('salespoint_id');
        $tickets = Ticket::where('status','>',5)
        ->whereIn('salespoint_id',$salespoint_ids)
        ->get();
        return view('Operational.po', compact('tickets'));
    }

    public function podetailView($ticket_code){
        try {
            $ticket = Ticket::where('code',$ticket_code)->first();
            if($ticket ==  null){
                throw new \Exception("Ticket tidak ditemukan");
            }
            $authorization_list = Authorization::where('form_type',3)->get();
            return view('Operational.podetail',compact('ticket','authorization_list'));
        } catch (\Exception $ex) {
            return back()->with('error',$ex->getMessage());
        }
    }

    public function submitPO(Request $request){
        try {
            DB::beginTransaction();
            $ticket_vendor = TicketVendor::find($request->ticket_vendor_id);
            if(isset($ticket_vendor->po)){
                throw new \Exception("PO sudah di proses sebelumnya oleh ". $ticket_vendor->po->created_by_employee()->name. 'pada '. $ticket_vendor->po->created_at->translatedFormat('d F Y (H:i)'));
            }else{
                $po                         = new Po;
                $po->ticket_vendor_id       = $request->ticket_vendor_id;
                $po->vendor_address         = $request->vendor_address;
                $po->send_address           = $request->send_address;
                $po->payment_days           = $request->payment_days;
                $po->no_pr_sap              = $request->no_pr_sap;
                $po->no_po_sap              = $request->no_po_sap;
                $po->supplier_pic_name      = $request->supplier_pic_name;
                $po->supplier_pic_position  = $request->supplier_pic_position;
                $po->notes                  = $request->notes;
                $po->created_by             = Auth::user()->id;
                $po->status                 = 0;
                $po->save();

                $authorization = Authorization::findOrFail($request->authorization_id);
                foreach($authorization->authorization_detail as $authorization){
                    $po_authorization                       = new PoAuthorization;
                    $po_authorization->po_id                = $po->id;
                    $po_authorization->employee_id          = $authorization->employee_id;
                    $po_authorization->employee_name        = $authorization->employee->name;
                    $po_authorization->as                   = $authorization->sign_as;
                    $po_authorization->employee_position    = $authorization->employee_position->name;
                    $po_authorization->level                = $authorization->level;
                    $po_authorization->save();
                }
            }
            DB::commit();
            return back()->with('success','Berhasil Menerbitkan PO');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Menerbitkan PO');
        }
    }

    public function printPO(Request $request){
        try {
            $po = Po::findOrFail($request->po_id);
            $pdf = PDF::loadView('pdf.popdf', compact('po'));
            
            return $pdf->download('invoice.pdf');
        } catch (\Exception $ex) {
            dd($ex);
            return back()->with('error','Gagal Mencetak PO '.$ex->getMessage());
        }
    }

    public function uploadInternalSignedFile(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            $ticket = $po->ticket_vendor->ticket;
            $salespointname = str_replace(' ','_',$ticket->salespoint->name);
            $ext = pathinfo($request->filename, PATHINFO_EXTENSION);
            $name = $po->no_po_sap."_INTERNAL_SIGNED_".$salespointname.'.'.$ext;
            $path = "/attachments/ticketing/barangjasa/".$ticket->code.'/po/'.$name;
        
            // base 64 data
            $file = explode('base64,',$request->file)[1];
            Storage::disk('public')->put($path, base64_decode($file));
            $po->internal_signed_filepath = $path;
            $po->status = 1;
            $po->save();

            DB::commit();
            return back()->with('success','Berhasil Upload File Intenal Signed untuk PO '.$po->no_po_sap.' File sudah dikirimkan ke supplier untuk ditandatangan');
        } catch (\Exception $ex) {
            db::rollback();
            return back()->with('error','Gagal Upload File '. $ex->getMessage()); 
        }
    }

    public function confirmPosigned(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            $po->status = 3;
            $po->save();
            DB::commit();
            return back()->with('success','Berhasil melakukan konfirmasi tanda tangan PO '.$po->no_po_sap.' dilanjutkan dengan penerimaan barang di salespoint/area bersangkutan');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Confirm Signed PO '.$ex->getMessage());
        }
    }

    public function sendEmail(Request $request){
        try {
            $po = Po::findOrFail($request->po_id);
            // $po_upload_request = new POUploadRequest;
            // $po_upload_request = $po->vendor_pic
            // $po_upload_request = $po->filepath
            // $po_upload_request = $po->status
            // $po_upload_request = $po->expired_date
            // $po_upload_request = $po->isOpened
            // $po_upload_request = $po->notes
            $mail = $request->email;
            $data = array(
                'po' => $po,
                'mail' => $mail,
            );
            Mail::to($mail)->send(new POMail($data, 'posignedrequest'));
            return back()->with('success', 'berhasil mengirim email untuk po '.$po->no_po_sap.' ke email '.$mail);
        } catch (\Exception $ex) {
            dd($ex);
            return back()->with('error','Gagal Mengirimkan email');
        }
    }
}
