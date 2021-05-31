<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\TicketVendor;
use App\Models\TicketItemFileRequirement;
use App\Models\TicketItemAttachment;
use App\Models\Authorization;
use App\Models\Bidding;
use App\Models\BiddingDetail;
use App\Models\BiddingAuthorization;
use Auth;
use DB;

class BiddingController extends Controller
{
    public function biddingView(){
        $biddings = Ticket::where('status',2)->get();
        return view('Operational.bidding',compact('biddings'));
    }

    public function biddingDetailView($ticket_code){
        $ticket = Ticket::where('code',$ticket_code)->first();
        if($ticket->status < 2){
            return back()->with('error','Tiket belum siap untuk dilakukan proses bidding');
        }
        return view('Operational.biddingdetail',compact('ticket'));
    }

    public function confirmFileRequirement(Request $request){
        try{
            if($request->type == 'file'){
                $item = TicketItemFileRequirement::findOrFail($request->id);
            }else if($request->type == 'attachment'){
                $item = TicketItemAttachment::findOrFail($request->id);
            }else{
                // ba_vendor
                $ticket = Ticket::findOrFail($request->id);
            }
            if($request->type == 'vendor'){
                $ticket->ba_status = 1;
                $ticket->ba_confirmed_by = Auth::user()->id;
                $ticket->save();
            }else{
                $item->status = 1;
                $item->confirmed_by = Auth::user()->id;
                $item->save();
            }
            return back()->with('success','Berhasil melakukan confirm kelengkapan');
        }catch(Exception $ex){
            return back()->with('error','Gagal melakukan confirm kelengkapan');
        }
    }

    public function rejectFileRequirement(Request $request){
        try{
            if($request->type == 'file'){
                // file
                $item = TicketItemFileRequirement::findOrFail($request->id);
            }else if($request->type == 'attachment'){
                // attachment
                $item = TicketItemAttachment::findOrFail($request->id);
            }else{
                // ba_vendor
                $ticket = Ticket::findOrFail($request->id);
            }
            
            if ($request->type == 'vendor') {
                $ticket->ba_status = -1;
                $ticket->ba_rejected_by = Auth::user()->id;
                $ticket->ba_reject_notes = $request->reason;
                $ticket->save();
            }else{
                $item->status = -1;
                $item->rejected_by = Auth::user()->id;
                $item->reject_notes = $request->reason;
                $item->save();
            }
            return back()->with('success','Berhasil melakukan reject kelengkapan');
        }catch(Exception $ex){
            return back()->with('error','Gagal melakukan reject kelengkapan');
        }
    }

    public function vendorSelectionView($ticket_code, $ticket_item_id){
        $ticket_item = TicketItem::find($ticket_item_id);
        $ticket = Ticket::where('code',$ticket_code)->first();
        $authorizations = Authorization::where('form_type',1)->get();
        // validate kalo misal item sama form codenya sesuai
        return view('Operational.vendorselection',compact('ticket_item','ticket','authorizations'));
    }

    public function addBiddingForm(Request $request){
        // dd($request);
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            $ticket_item = TicketItem::find($request->ticket_item_id);
            $newBidding                             = new Bidding;
            $newBidding->ticket_id                  = $request->ticket_id;    
            $newBidding->ticket_item_id             = $request->ticket_item_id;            
            $newBidding->product_name               = $ticket_item->name;        
            $newBidding->salespoint_name            = $ticket->salespoint->name;            
            $newBidding->group                      = $request->group;
            $newBidding->other_name                 = ($request->group == 'others')?$request->others_name:'-';        
            $newBidding->price_notes                = $request->keterangan_harga;        
            $newBidding->ketersediaan_barang_notes  = $request->keterangan_ketersediaan;                    
            $newBidding->ketentuan_bayar_notes      = $request->keterangan_pembayaran;                
            $newBidding->others_notes               = $request->keterangan_lain;        
            $newBidding->authorization_id           = $request->authorization_id;
            $newBidding->optional1_name             = $request->optional1_name;     
            $newBidding->optional2_name             = $request->optional1_name;     
            $newBidding->save();

            foreach($request->vendor as $vendor){
                $selectedticketvendor = TicketVendor::find($vendor['ticket_vendor_id']);
                $newdetail                            = new BiddingDetail;
                $newdetail->bidding_id                = $newBidding->id;    
                $newdetail->ticket_vendor_id          = $selectedticketvendor->id;
                $newdetail->address                   = ($selectedticketvendor->vendor_id) ? $selectedticketvendor->vendor_id : $vendor['address'];
                $newdetail->start_harga               = $vendor['harga_awal'];
                $newdetail->end_harga                 = $vendor['harga_akhir'];
                $newdetail->start_ppn                 = $vendor['ppn_awal'];
                $newdetail->end_ppn                   = $vendor['ppn_akhir'];
                $newdetail->start_ongkir_price        = $vendor['send_fee_awal'];
                $newdetail->end_ongkir_price          = $vendor['send_fee_akhir'];
                $newdetail->start_pasang_price        = $vendor['apply_fee_awal'];
                $newdetail->end_pasang_price          = $vendor['apply_fee_akhir'];
                $newdetail->price_score               = $vendor['nilai_harga']    ;
                $newdetail->spesifikasi               = $vendor['specs'];
                $newdetail->ready                     = $vendor['ready'];
                $newdetail->indent                    = $vendor['indent'];
                $newdetail->garansi                   = $vendor['garansi'];
                $newdetail->bonus                     = $vendor['bonus'];
                $newdetail->ketersediaan_barang_score = $vendor['nilai_ketersediaan'];
                $newdetail->creditcash                = $vendor['cc'];
                $newdetail->menerbitkan_faktur_pajak  = $vendor['pajak'];
                $newdetail->ketentuan_bayar_score     = $vendor['nilai_pembayaran'];
                $newdetail->masa_berlaku_penawaran    = $vendor['period'];
                $newdetail->start_lama_pengerjaan     = $vendor['time_awal'];
                $newdetail->end_lama_pengerjaan       = $vendor['time_akhir'];
                $newdetail->optional1_start           = $vendor['optional1_awal'];
                $newdetail->optional1_end             = $vendor['optional1_akhir'];
                $newdetail->optional2_start           = $vendor['optional2_awal'];
                $newdetail->optional2_end             = $vendor['optional2_akhir'];
                $newdetail->others_score              = $vendor['nilai_other'];
                $newdetail->save();
            }

            $authorization = Authorization::find($request->authorization_id);
            foreach($authorization->authorization_detail as $detail) {
                $newauthorization                    = new BiddingAuthorization;
                $newauthorization->bidding_id        = $newBidding->id;
                $newauthorization->employee_id       = $detail->employee_id;
                $newauthorization->employee_name     = $detail->employee->name;
                $newauthorization->as                = $detail->sign_as;
                $newauthorization->employee_position = $detail->employee->employee_position->name;
                $newauthorization->level             = $detail->level;
                $newauthorization->save();
            }
            DB::commit();
            return redirect('/bidding/'.$ticket->code)->with('success','Berhasil membuat form bidding. Harap Menunggu proses otorisasi');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect('/bidding/'.$ticket->code)->with('error','Gagal membuat form bidding. Silahkan coba kembali atau hubungi admin');
            //throw $th;
        }

    }
}
