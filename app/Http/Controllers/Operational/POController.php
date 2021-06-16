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
use Illuminate\Support\Str;


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
            $po = Po::where('no_po_sap',$request->input('code'))->first();
            if(!$po){
                throw new \Exception('PO tidak ditemukan');
            }
            $pdf = PDF::loadView('pdf.popdf', compact('po'));
            return $pdf->stream('PO ('.$po->no_po_sap.').pdf');
            // return $pdf->download('invoice.pdf');
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

            $po_upload_request               = new POUploadRequest;
            $po_upload_request->id           = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->ticket_vendor->name;
            $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            $po_upload_request->save();

            $mail = $request->email;
            $data = array(
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedrequest'));

            DB::commit();
            return back()->with('success','Berhasil Upload File Intenal Signed untuk PO '.$po->no_po_sap.' File sudah dikirimkan ke email supplier ('.$mail.') untuk ditandatangan');
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
            
            $po_upload_request = $po->po_upload_request();
            $po_upload_request->status = 2;
            $po_upload_request->save();
            
            $po->external_signed_filepath = $po_upload_request->filepath;
            $po->save();

            DB::commit();
            return back()->with('success','Berhasil melakukan konfirmasi tanda tangan PO '.$po->no_po_sap.' dilanjutkan dengan penerimaan barang di salespoint/area bersangkutan');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Confirm Signed PO '.$ex->getMessage());
        }
    }

    public function rejectPosigned(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);
            $po->status = 1;
            $po->save();

            $porequest = POUploadRequest::findOrFail($request->po_upload_request_id);
            $porequest->notes = $request->reason;
            $porequest->isExpired = true;
            $porequest->status = -1;
            $porequest->save();

            $po_upload_request               = new POUploadRequest;
            $po_upload_request->id           = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->ticket_vendor->name;
            $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            $po_upload_request->save();

            $mail = $request->email;
            $data = array(
                'reject_notes' => $request->reason,
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'new_url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedreject'));
            DB::commit();
            return back()->with('success','Berhasil melakukan penolakan tanda tangan PO '.$po->no_po_sap.' link baru telah dikirim ke email '.$mail);
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal Confirm Signed PO '.$ex->getMessage());
        }
    }

    public function sendEmail(Request $request){
        try {
            DB::beginTransaction();
            $po = Po::findOrFail($request->po_id);

            $old_po_upload_request = $po->po_upload_request();
            if($old_po_upload_request){
                $old_po_upload_request->isExpired = true;
                $old_po_upload_request->save();
                $old_po_upload_request->delete();
            }

            $po_upload_request = new POUploadRequest;
            $po_upload_request->id = (string) Str::uuid();
            $po_upload_request->po_id        = $po->id;
            $po_upload_request->vendor_name  = $po->ticket_vendor->name;
            $po_upload_request->vendor_pic   = $po->ticket_vendor->salesperson;
            $po_upload_request->notes        = $po->id;
            $po_upload_request->save();
            $mail = $request->email;
            $data = array(
                'po' => $po,
                'mail' => $mail,
                'po_upload_request' => $po_upload_request,
                'url' => url('/signpo/'.$po_upload_request->id)
            );
            Mail::to($mail)->send(new POMail($data, 'posignedrequest'));
            DB::commit();
            return back()->with('success', 'berhasil mengirim email untuk po '.$po->no_po_sap.' ke email '.$mail);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal Mengirimkan email');
        }
    }

    public function poUploadRequestView($po_upload_request_id){
        try{
            $poupload = POUploadRequest::where('id',$po_upload_request_id)->where('isExpired',false)->first();
            if(!$poupload){
                throw new \Exception('Document expired or not found');
            }
            $poupload->isOpened = true;
            $poupload->save();
            return view('Operational.poupload',compact('poupload'));
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function poUploadRequest(Request $request){
        try{
            DB::beginTransaction();
            $pouploadrequest = POUploadRequest::findOrFail($request->po_upload_request_id);
            if($request->file()){
                $internal_signed_filepath = $pouploadrequest->po->internal_signed_filepath;
                $filepath = str_replace('INTERNAL_SIGNED','EXTERNAL_SIGNED',$internal_signed_filepath);
                $newext = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION);
                $filepath = $this->replace_extension($filepath,$newext);
                $file =pathinfo($filepath);
                $path = $request->file('file')->storeAs($file['dirname'],$file['basename'],'public');
                $pouploadrequest->filepath = $path;
                $pouploadrequest->status = 1;
                $pouploadrequest->save();

                $po = $pouploadrequest->po;
                $po->status = 2;
                $po->save();
                DB::commit();
                return back()->with('success','Berhasil upload file');
            }else{
                DB::rollback();
                throw new \Exception("File tidak ditemukan");
            }
        }catch (\Exception $ex){
            dd($ex);
            return back()->with('error',$ex->getMessage());
        }
    }
    function replace_extension($filename, $new_extension) {
        $info = pathinfo($filename);
        return $info['dirname'].'/'.$info['filename'] . '.' . $new_extension;
    }
}
