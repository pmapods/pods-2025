<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\TicketVendor;
use App\Models\TicketItemFileRequirement;
use App\Models\TicketItemAttachment;
use App\Models\TicketMonitoring;
use App\Models\Authorization;
use App\Models\Bidding;
use App\Models\BiddingDetail;
use App\Models\BiddingAuthorization;
use Auth;
use DB;
use PDF;
use Storage;
use Crypt;

class BiddingController extends Controller
{
    public function biddingView(Request $request){
        if($request->input('status') == -1){
            $tickets = Ticket::all()
            ->sortByDesc('created_at');
        }else{
            $tickets = Ticket::whereIn('status',[2,3])
            ->get()
            ->sortByDesc('created_at');
        }
        return view('Operational.bidding',compact('tickets'));
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

                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Konfirmasi berita acara pengajuan vendor';
                $monitor->save();
            }else{
                $item->status = 1;
                $item->confirmed_by = Auth::user()->id;
                $item->save();

                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $item->ticket_item->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Konfirmasi file pengadaan'.$item->name;
                $monitor->save();
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
                
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Reject berita acara vendor';
                $monitor->save();
            }else{
                $item->status = -1;
                $item->rejected_by = Auth::user()->id;
                $item->reject_notes = $request->reason;
                $item->save();
                
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $item->ticket_item->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Reject file pengadaan'.$item->name;
                $monitor->save();
            }
            return back()->with('success','Berhasil melakukan reject kelengkapan');
        }catch(Exception $ex){
            return back()->with('error','Gagal melakukan reject kelengkapan');
        }
    }

    public function removeTicketItem(Request $request){
        try{
            DB::beginTransaction();
            $ticket_item                = TicketItem::find($request->ticket_item_id);
            $ticket_item->isCancelled   = true;
            $ticket_item->cancelled_by  = Auth::user()->id;
            $ticket_item->cancel_reason = $request->reason;
            $ticket_item->save();
            
            $isvalidated =  $this->validateBiddingDone($ticket_item->ticket->id);
            if($isvalidated){
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $ticket_item->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Menghapus item '.$ticket_item->name.' dari pengadaan';
                $monitor->save();

                DB::commit();
                return redirect('/bidding/'.$ticket_item->ticket->code)->with('success','Berhasil Menghapus item, seluruh otorisasi Bidding telah selesai, Silahkan melanjutkan proses di menu Purchase Requistion'); 
            }else{
                DB::commit();
                return back()->with('success','Berhasil menghapus item.');
            }
        }catch(\Exception $ex){
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal menghapus item '.$ex->getMessage());
        } 
    }

    public function vendorSelectionView($ticket_code, $ticket_item_id){
        $ticket_item = TicketItem::find($ticket_item_id);
        $ticket = Ticket::where('code',$ticket_code)->first();
        $authorizations = Authorization::where('form_type',1)->get();
        // validate kalo misal item sama form codenya sesuai
        if($ticket_item->bidding){
            $bidding = $ticket_item->bidding;
            if($ticket_item->bidding->status == -1){
                return view('Operational.vendorselection',compact('ticket_item','ticket','authorizations','bidding'));
            }else{
                return view('Operational.vendorselectionresult',compact('ticket_item','ticket','bidding'));
            }
        }
        return view('Operational.vendorselection',compact('ticket_item','ticket','authorizations'));
    }

    public function addBiddingForm(Request $request){
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($request->ticket_id);
            $ticket_item = TicketItem::find($request->ticket_item_id);
            if($ticket_item->bidding){
                $newBidding = $ticket_item->bidding;
                // remove old data on detail and authorization
                foreach($newBidding->bidding_detail as $detail){
                    $detail->delete();
                }

                foreach($newBidding->bidding_authorization as $authorization){
                    $authorization->delete();
                }
            }else{
                $newBidding                         = new Bidding;
            }
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
            $newBidding->optional2_name             = $request->optional2_name;
            $newBidding->status                     = 0;
            $newBidding->rejected_by = null;
            $newBidding->reject_notes = null;
            $newBidding->save();

            foreach($request->vendor as $vendor){
                $selectedticketvendor = TicketVendor::find($vendor['ticket_vendor_id']);
                $newdetail                            = new BiddingDetail;
                $newdetail->bidding_id                = $newBidding->id;    
                $newdetail->ticket_vendor_id          = $selectedticketvendor->id;
                $newdetail->address                   = ($selectedticketvendor->vendor_id) ? $selectedticketvendor->vendor()->address : $vendor['address'];
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
                $newauthorization->employee_position = $detail->employee_position->name;
                $newauthorization->level             = $detail->level;
                $newauthorization->save();
            }

            $monitor = new TicketMonitoring;
            $monitor->ticket_id      = $ticket->id;
            $monitor->employee_id    = Auth::user()->id;
            $monitor->employee_name  = Auth::user()->name;
            $monitor->message        = 'Membuat Form Bidding item "'.$newBidding->ticket_item->name.'" untuk di otorisasi';
            $monitor->save();
            DB::commit();
            
            return redirect('/bidding/'.$ticket->code.'/'.$request->ticket_item_id)->with('success','Berhasil membuat form bidding. Harap Menunggu proses otorisasi');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect('/bidding/'.$ticket->code)->with('error','Gagal membuat form bidding. Silahkan coba kembali atau hubungi developer');
        }

    }

    public function approveBidding(Request $request) {
        try{
            DB::beginTransaction();
            $bidding = Bidding::find($request->bidding_id);
            if(($bidding->signed_filename == null || $bidding->signed_filepath == null) && $bidding->current_authorization()->level == 2 && Auth::user()->id == $bidding->current_authorization()->employee->id){
                return back()->with('error','Harap melakukan upload file penawaran yang sudah di tanda tangan');
            }
            $bidding_authorization = BiddingAuthorization::find($request->bidding_authorization_id);
            if($bidding_authorization->employee_id == Auth::user()->id){
                $bidding_authorization->status = 1;
                $bidding_authorization->save();

                $bidding = Bidding::find($request->bidding_id);
                $next_authorization_text = ($bidding->current_authorization() != null)?'(otorisasi selanjutnya '.$bidding->current_authorization()->employee->name.')' : '';
                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $bidding->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Melakukan Approval Bidding item "'.$bidding->product_name.'" '.$next_authorization_text;
                $monitor->save();
                if($bidding->current_authorization() != null){
                    DB::commit();
                    return redirect('/bidding/'.$bidding->ticket->code)->with('success','Approval Bidding berhasil, menunggu otorisasi selanjutnya oleh '.$bidding->current_authorization()->employee->name);
                }else{
                    $bidding->status = 1;
                    $bidding->save();
                    DB::commit();
                    $isvalidated =  $this->validateBiddingDone($bidding->ticket->id);
                    if($isvalidated){
                        return redirect('/bidding/'.$bidding->ticket->code)->with('success','Seluruh Otorisasi Bidding telah selesai, Silahkan melanjutkan proses di menu Purchase Requistion'); 
                    }
                    return redirect('/bidding/'.$bidding->ticket->code)->with('success','Otorisasi telah selesai');
                }
            }else{
                throw new \Exception('Otorisasi login tidak sesuai');
            }
        }catch(\Exception $ex){
            DB::rollback();
            return back()->with('error','Gagal melakukan otorisasi ('.$ex->getMessage().')');
        }
    }

    public function rejectBidding(Request $request) {
        try {
            DB::beginTransaction();
            $bidding = Bidding::find($request->bidding_id);
            $bidding_authorization = BiddingAuthorization::find($request->bidding_authorization_id);
            if($bidding_authorization->employee_id == Auth::user()->id){
                $bidding_authorization->status = -1;
                $bidding_authorization->save();

                $bidding_authorization->bidding->status = -1;
                $bidding_authorization->bidding->rejected_by = Auth::user()->id;
                $bidding_authorization->bidding->reject_notes = $request->reason;
                $bidding_authorization->bidding->signed_filename = null;
                Storage::disk('public')->delete($bidding_authorization->bidding->signed_filepath);
                $bidding_authorization->bidding->signed_filepath = null;
                $bidding_authorization->bidding->save();

                $monitor = new TicketMonitoring;
                $monitor->ticket_id      = $bidding->ticket->id;
                $monitor->employee_id    = Auth::user()->id;
                $monitor->employee_name  = Auth::user()->name;
                $monitor->message        = 'Melakukan Reject Bidding';
                $monitor->save();
                DB::commit();

                return redirect('/bidding/'.$bidding->ticket->code)->with('success','Berhasil melakukan reject form bidding. Silahkan melakukan pengajuan ulang');
            }else{
                 DB::rollback();
                return redirect('/bidding/'.$bidding->ticket->code)->with('error','Otorisasi login tidak sesuai');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect('/bidding/'.$bidding->ticket->code)->with('error','Reject form bidding gagal, silahkan coba kembali atau hubungi developer');
        }
    }

    public function uploadSignedFile(Request $request){
        try{
            $bidding = Bidding::findOrFail($request->bidding_id);
            $salespointname = str_replace(' ','_',$bidding->ticket->salespoint->name);
            $newext = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = "Penawaran_resmi_dari_2_vendor_(dilengkapi_KTP_dan_NPWP)_SIGNED_".$salespointname.'.'.$newext;
            $path = "/attachments/ticketing/barangjasa/".$bidding->ticket->code.'/item'.$bidding->ticket_item->id.'/files/'.$name;
            $file = pathinfo($path);
            $path = $request->file('file')->storeAs($file['dirname'],$file['basename'],'public');
            $bidding->signed_filename = $file['basename'];
            $bidding->signed_filepath = $path;
            $bidding->save();
            return back()->with('success','Berhasil upload file penawaran yang sudah ditandatangan, Silahkan melanjutkan proses approval');
        }catch(\Exception $ex){
            return redirect('/bidding/'.$bidding->ticket->code)->with('error','Gagal upload file penawaran yang ditandatangan');
        }

    }

    public function validateBiddingDone($ticket_id) {
        $ticket = Ticket::findOrFail($ticket_id);
        $flag = true;
        foreach($ticket->ticket_item->where('isCancelled','!=',true) as $ticket_item){
            if(isset($ticket_item->bidding)){
                if($ticket_item->bidding->status != 1){
                    $flag = false;
                }
            }else{
                $flag = false;
            }
        }
        if($flag){
            $ticket->status = 3;
            $ticket->save();
        }
        return $flag;
    }

    public function terminateTicket(Request $request){
        try {
            DB::beginTransaction();
            $ticket = Ticket::findOrFail($request->ticket_id);
            if($ticket->status==3){
                return back()->with('error','Ticket yang sudah mencapai proses PR tidak dapat dibatalkan');
            }
            $ticket->status = -1;
            $ticket->terminated_by = Auth::user()->id;
            $ticket->termination_reason = $request->reason;
            $ticket->save();

            $monitor = new TicketMonitoring;
            $monitor->ticket_id      = $ticket->id;
            $monitor->employee_id    = Auth::user()->id;
            $monitor->employee_name  = Auth::user()->name;
            $monitor->message        = 'Membatalkan Ticket Pengadaan';
            $monitor->save();
            DB::commit();
            return redirect('/bidding')->with('success','Berhasil membatalkan pengadaan '.$ticket->code);
        } catch (\Exception $ex) {
            DB::rollback();
            return back('/bidding')->with('error','Gagal membatalkan pengadaan '.$ex->getMessage());
        }
    }

    public function biddingPrintView($encrypted_bidding_id){
        try {
            $decrypted = Crypt::decryptString($encrypted_bidding_id);
        } catch (\Exception $ex) {
            abort(404);
        }
        $bidding = Bidding::find($decrypted);
        $ticket_item = $bidding->ticket_item;
        $ticket = $bidding->ticket;
        return view('Operational.biddingprintoutview',compact('ticket_item','ticket','bidding'));
    }
}
