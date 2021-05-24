<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;
use App\Models\BudgetPricingCategory;
use App\Models\BudgetPricing;
use App\Models\Vendor;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\TicketItemAttachment;
use App\Models\TicketVendor;
use App\Models\Authorization;
use App\Models\TicketAuthorization;
use App\Models\TicketAdditionalAttachment;
use App\Models\FileCategory;
use Auth;
use DB;
use Storage;
use Carbon\Carbon;

class TicketingController extends Controller
{
    public function ticketingView(){
        // show ticket liat based on auth access area
        $access = Auth::user()->location_access->pluck('salespoint_id');
        $tickets = Ticket::whereIn('salespoint_id',$access)->get()->sortByDesc('created_at');
        
        return view('Operational.ticketing',compact('tickets'));
    }

    public function ticketingDetailView($code){
        $ticket = Ticket::where('code',$code)->first();
        if($ticket){
            $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
            $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
            $available_salespoints = $available_salespoints->groupBy('region');
            
            $budget_category_items = BudgetPricingCategory::all();
    
            // active vendors
            $vendors = Vendor::where('status',0)->get();
    
            // show ticket liat based on auth access area
            $access = Auth::user()->location_access->pluck('salespoint_id');

            // show file completement data
            $filecategories = FileCategory::all();
            if($ticket->status == 0){
                // if draft make it editable
                return view('Operational.ticketingdetail',compact('ticket','available_salespoints','budget_category_items','vendors','filecategories'));
            }else{
                return view('Operational.ticketingform',compact('ticket','available_salespoints','budget_category_items','vendors','filecategories'));
            }
        }else{
            return redirect('/ticketing')->with('error','Form tidak ditemukan');
        }
    }

    public function addNewTicket(Request $request){
        if($request->ticketing_type == '0'){
            $user_location_access = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
            $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
            $available_salespoints = $available_salespoints->groupBy('region');
            
            $budget_category_items = BudgetPricingCategory::all();

            // active vendors
            $vendors = Vendor::where('status',0)->get();

            // show ticket liat based on auth access area
            $access = Auth::user()->location_access->pluck('salespoint_id');
            
            // show file completement data
            $filecategories = FileCategory::all();
            return view('Operational.ticketingdetail',compact('available_salespoints','budget_category_items','vendors','filecategories'));
        }else{
            return back()->with('error','Terjadi Kesalahan silahakan mencoba lagi');
        }
    }

    public function deleteTicket(Request $request){
        $ticket = Ticket::where('code',$request->code)->first();
        if($ticket){
            $ticket->delete();
            return redirect('/ticketing')->with('success','Berhasil Menghapus Ticket');
        }else{
            return redirect('/ticketing')->with('error','Gagal Menghapus Ticket');
        }
    }

    public function addTicket(Request $request){
        try {
            DB::beginTransaction();
            if(!isset($request->salespoint)){
                return back()->with('error','Salespoint harus dipilih');
            }
            $ticket = Ticket::find($request->id);
            $isnew = true;
            if($ticket == null){
                $ticket = new Ticket;
            }else{
                $isnew = false;
            }
            $ticket->requirement_date   = $request->requirement_date;
            $ticket->salespoint_id      = $request->salespoint;
            $ticket->authorization_id   = $request->authorization;
            $ticket->item_type          = $request->item_type;
            $ticket->request_type       = $request->request_type;
            $ticket->budget_type        = $request->budget_type;
            $ticket->reason             = $request->reason;
            $ticket->save();
            if($ticket->code == null){
                $ticket->code = 'draft_'.date('ymdHi').$ticket->id;
            }
            if($request->ba_vendor_name != null && $request->ba_vendor_file != null){
                $ticket->ba_vendor_filename = $request->ba_vendor_name;
                $path = "/attachments/ticketing/barangjasa/".$ticket->code.'/'.$request->ba_vendor_name;
                
                if(str_contains($request->ba_vendor_file, 'http')){
                    // url
                    $file = Storage::disk('public')->get(explode('storage',$request->ba_vendor_file)[1]);
                    Storage::disk('public')->put($path, $file);
                }else{
                    // base 64 data
                    $file = explode('base64,',$request->ba_vendor_file)[1];
                    Storage::disk('public')->put($path, base64_decode($file));
                }
                $ticket->ba_vendor_filepath = $path;
            }else{
                $ticket->ba_vendor_filename = null;
                $ticket->ba_vendor_filepath = null;
            }
            $ticket->save();
            $salespoint = $ticket->salespoint;

            // remove old data
            if($ticket->ticket_item->count() > 0){
                // get deleted new data
                $registered_id = collect($request->item)->pluck('id')->filter(function($item){
                    if($item != "undefined"){
                        return true;
                    }else{
                        return false;
                    }
                });
                $deleted_item =[];
                if($ticket->ticket_item->count()>0){
                    $deleted_item = $ticket->ticket_item->whereNotIn('id',$registered_id);
                }
                foreach($deleted_item as $deleted){
                    $deleted->delete();
                }
            }
            // add ticket item that not registered
            $newitems = collect($request->item)->where('id','undefined');
            if(isset($newitems)){
                foreach($newitems as $key=>$item) {
                    $newTicketItem                        = new TicketItem;
                    $newTicketItem->ticket_id             = $ticket->id;
                    if($item['budget_pricing_id'] != "undefined"){
                        $newTicketItem->budget_pricing_id     = $item['budget_pricing_id'];
                    }
                    $newTicketItem->name                  = $item['name'];
                    $newTicketItem->brand                 = $item['brand'];
                    $newTicketItem->type                  = $item['type'];
                    $newTicketItem->price                 = $item['price'];
                    $newTicketItem->count                 = $item['count'];
                    $newTicketItem->save();
                    if(isset($item["attachments"])){
                        foreach($item["attachments"] as $attachment){
                            $newAttachment = new TicketItemAttachment;
                            $newAttachment->ticket_item_id = $newTicketItem->id;
                            $newAttachment->name = $attachment['filename'];
                            $path = "/attachments/ticketing/barangjasa/".$ticket->code.'/item'.$newTicketItem->id.'/'.$attachment['filename'];
                            if(str_contains($attachment['file'], 'http')){
                                $file = Storage::disk('public')->get(explode('storage',$attachment['file'])[1]);
                                Storage::disk('public')->put($path, $file);
                            }else{
                                // base 64 data
                                $file = explode('base64,',$attachment['file'])[1];
                                Storage::disk('public')->put($path, base64_decode($file));
                            }
                            $newAttachment->path = $path;
                            $newAttachment->save();
                        }
                    }
                }
            }

            // ticket vendor
            if($ticket->ticket_vendor->count() > 0){
                $registered_id = collect($request->vendor)->pluck('id')->filter(function($item){
                    if($item != "undefined"){
                        return true;
                    }else{
                        return false;
                    }
                });
                $deleted_item=[];
                if($ticket->ticket_vendor->count()>0){
                    $deleted_item = $ticket->ticket_vendor->whereNotIn('id',$registered_id);
                }
                foreach($deleted_item as $deleted){
                    $deleted->delete();
                }
            }
            // add ticket vendor that not registered yet
            $newitems = collect($request->vendor)->where('id','undefined');
            if(isset($newitems)){
                foreach ($newitems as $list){
                    $vendor = Vendor::find($list['vendor_id']);
                    $newTicketVendor = new TicketVendor;
                    $newTicketVendor->ticket_id         = $ticket->id;
                    if($vendor){
                        $newTicketVendor->vendor_id     = $vendor->id;
                        $newTicketVendor->name          = $vendor->name;
                        $newTicketVendor->salesperson   = $vendor->salesperson;
                        // hide phone on order (personal for purhasing team)
                        $newTicketVendor->phone         = '';
                        $newTicketVendor->type          = 0;
                    }else{
                        $newTicketVendor->vendor_id     = null;
                        $newTicketVendor->name          = $list['name'];
                        $newTicketVendor->salesperson   = $list['sales'];
                        $newTicketVendor->phone         = $list['phone'];
                        $newTicketVendor->type          = 1;
                    }
                    $newTicketVendor->save();
                }
            }

            // ticket authorization
            if(isset($ticket->ticket_authorization)){
                if($ticket->ticket_authorization->count() > 0){
                    foreach($ticket->ticket_authorization as $auth){
                        $auth->delete();
                    }
                }
            }
            $authorizations = Authorization::find($request->authorization);
            if(isset($authorizations)){
                foreach($authorizations->authorization_detail as $detail){
                    $newTicketAuthorization                     = new TicketAuthorization;
                    $newTicketAuthorization->ticket_id          = $ticket->id;
                    $newTicketAuthorization->employee_id        = $detail->employee_id;
                    $newTicketAuthorization->employee_name      = $detail->employee->name;
                    $newTicketAuthorization->as                 = $detail->sign_as;
                    $newTicketAuthorization->employee_position  = $detail->employee->employee_position->name;
                    $newTicketAuthorization->level              = $detail->level;
                    $newTicketAuthorization->save();
                }
            }

            // optional attachment
            if($ticket->ticket_additional_attachment->count() > 0){
                foreach($ticket->ticket_additional_attachment as $attach){
                    $attach->delete();
                }
            }
            if(isset($request->opt_attach)){
                foreach($request->opt_attach as $attach){
                    $path = '/attachments/ticketing/barangjasa/'.$ticket->code.'/optional_attachment/'.$attach['name'];
                    if(str_contains($attach['file'], 'http')){
                        // url
                        $replaced = str_replace('%20', ' ', explode('storage',$attach['file'])[1]);;
                        $file = Storage::disk('public')->get($replaced);
                        Storage::disk('public')->put($path, $file);
                    }else{
                        // base 64 data
                        $file = explode('base64,',$attach['file'])[1];
                        Storage::disk('public')->put($path, base64_decode($file));
                    }
                    $newAttachment = new TicketAdditionalAttachment;
                    $newAttachment->ticket_id = $ticket->id;
                    $newAttachment->name = $attach['name'];
                    $newAttachment->path = $path;
                    $newAttachment->save();
                }
            }
            DB::commit();
            if($request->type == 1){
                // start authorization
                $ticket = Ticket::find($ticket->id);
                return $this->startAuthorization($ticket);
            }else{
                if($isnew){
                    return redirect('/ticketing')->with('success','Berhasil menambah form pengadaan kedalam draft. Silahkan melakukan review kembali');
                }else{
                    return back()->with('success','Berhasil update form pengadaan');
                }
            }
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menyimpan tiket "'.$ex->getMessage().'"');
        }
    }

    public function startAuthorization($ticket){
        try{
            DB::beginTransaction();
            $validate = $this->validateticket($ticket);
            if($validate['error']){
                return redirect('/ticketing/'.$ticket->code)->with('error',implode(',',$validate['messages']));
            }
            $count_ticket = Ticket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->where('status','>',0)
            ->withTrashed()
            ->count();
            do {
                $code = "PCD-".now()->format('ymd').'-'.str_repeat("0", 4-strlen($count_ticket+1)).($count_ticket+1);
                $count_ticket++;
                $checkticket = Ticket::where('code',$code)->first();
                ($checkticket)? $flag = false : $flag = true;
            } while (!$flag);
            $old_code               = $ticket->code;
            $ticket->code           = $code;
            $ticket->created_at     = Carbon::now()->format('Y-m-d H:i:s');
            $ticket->created_by     = Auth::user()->id;
            $ticket->status = 1;
            // cari oper semua path kode lama ke kode baru
            $oldpath ='/attachments/ticketing/barangjasa/'.$old_code;
            $newpath ='/attachments/ticketing/barangjasa/'.$ticket->code;
            if($ticket->ba_vendor_filepath != null){
                $ticket->ba_vendor_filepath = str_replace($oldpath,$newpath,$ticket->ba_vendor_filepath);
                $ticket->save();
            }

            $ticket_item_attachments = TicketItemAttachment::where('path', 'LIKE', $oldpath.'%')->get();
            foreach($ticket_item_attachments as $attachment){
                $attachment->path = str_replace($oldpath,$newpath,$attachment->path);
                $attachment->save();
            }
            // end cari oper semua path kode
            $oldpath = 'storage'.$oldpath;
            $newpath = 'storage'.$newpath;
            // dd($oldpath,$newpath);
            if(is_dir($oldpath)){
                rename($oldpath,$newpath);
            }
            $ticket->save();
            DB::commit();
            // oper path
            return redirect('/ticketing')->with('success','Berhasil memulai otorisasi untuk form '.$ticket->code);
        }catch (\Exception $ex){
            DB::rollback();
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage().'('.$ex->getLine().')');
        }
    }

    public function validateticket($ticket){
        $messages = array();
        $flag = true;
        if(!isset($ticket->requirement_date)){
            array_push($messages,'Tanggal Pengadaan harus dipilih');
        }
        // jumlah item minimal 1
        if($ticket->ticket_item->count() < 1){
            array_push($messages,"Jumlah permintaan item minimal 1");
            $flag = false;
        }
        // jika vendor 1 butuh berita acara
        if($ticket->ticket_vendor->count() == 1 && $ticket->ba_vendor_filepath == null){
            array_push($messages,"Untuk pemilihan hanya satu vendor membutuhkan berita acara vendor");
            $flag = false;
        }
        // vendor gaboleh kosong 
        if($ticket->ticket_vendor->count() == 0){
            array_push($messages,"Silahkan ajukan / pilih 2 vendor");
            $flag = false;
        }
        // alasan harus diisi
        if(!isset($ticket->reason)){
            array_push($messages,'Alasan pengadaan barang atau jasa harus diisi');
        }
        $data = collect([
            "error" => !$flag,
            "messages" => $messages
        ]);
        return $data;
    }

    public function approveTicket(Request $request){
        try{
            $ticket = Ticket::findOrFail($request->id);
            $updated_at = new Carbon($request->updated_at);
            if ($updated_at == $ticket->updated_at) {
                $authorization = $ticket->current_authorization();
                if($authorization->employee_id == Auth::user()->id){
                    // set status jadi approve
                    $authorization->status = 1;
                    $authorization->save();
                    $this->checkTicketApproval($ticket->id);
                    return redirect('/ticketing')->with('success','Berhasil melakukan approve ticket');
                }else{
                    return back()->with('error','ID otorisasi tidak sesuai. Silahkan coba kembali');
                }
            }else{
                return back()->with('error','Ticket sudah di approve sebelumnya');
            }
        }catch (\Exception $ex){
            return back()->with('error','Gagal melakukan approve ticket '.$ex->getMessage());
        }
    }

    public function checkTicketApproval($ticket_id){
        try{
            $ticket = Ticket::findOrFail($ticket_id);
            $flag = true;
            foreach($ticket->ticket_authorization as $authorization){
                if($authorization->status != 1){
                    $flag = false;
                    break;
                }
            }
            if($flag){
                $ticket->status = 2;
                $ticket->save();
            }
        }catch (\Exception $ex){
            return back()->with('error','Approval checker error please contact admin '.$ex->getMessage());
        }
    }

    public function rejectTicket(Request $request){
        try{
            $ticket = Ticket::findOrFail($request->id);
            $updated_at = new Carbon($request->updated_at);
            if ($updated_at == $ticket->updated_at) {
                $ticket->status = 3;
                $ticket->terminated_by = Auth::user()->id;
                $ticket->termination_reason = $request->reason;
                $ticket->save();
                return back()->with('success','Berhasil membatalkan ticket');
            }else{
                return back()->with('error','Ticket sudah dibatalkan sebelumnya');
            }
        }catch (\Exception $ex){
            return back()->with('error','Gagal membatalkan ticket '.$ex->getMessage());
        }
    }
}
