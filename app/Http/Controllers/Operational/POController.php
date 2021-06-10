<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Ticket;
use App\Models\TicketVendor;
use App\Models\Po;
use PDF;
use DB;
use Storage;

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
            return view('Operational.podetail',compact('ticket'));
        } catch (\Exception $ex) {
            return back()->with('error',$ex->getMessage());
        }
    }

    public function submitPO(Request $request){
        try {
            $ticket_vendor = TicketVendor::find($request->ticket_vendor_id);
            if(isset($ticket_vendor->po)){
                throw new \Exception("PO sudah di proses sebelumnya oleh ". $ticket_vendor->po->created_by_employee()->name. 'pada '. $ticket_vendor->po->created_at->translatedFormat('d F Y (H:i)'));
            }else{
                $po                   = new Po;
                $po->ticket_vendor_id = $request->ticket_vendor_id;
                $po->vendor_address   = $request->vendor_address;
                $po->send_address     = $request->send_address;
                $po->payment_days     = $request->payment_days;
                $po->no_pr_sap        = $request->no_pr_sap;
                $po->no_po_sap        = $request->no_po_sap;
                $po->notes            = $request->notes;
                $po->created_by       = Auth::user()->id;
                $po->status           = 0;
                $po->save();
            }
            return back()->with('success','Berhasil Menerbitkan PO');
        } catch (\Exception $ex) {
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
}
