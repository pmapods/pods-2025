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
            $user_location_access = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
            $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
            $available_salespoints = $available_salespoints->groupBy('region');
            
            $budget_category_items = BudgetPricingCategory::all();
    
            // active vendors
            $vendors = Vendor::where('status',0)->get();
    
            // show ticket liat based on auth access area
            $access = Auth::user()->location_access->pluck('salespoint_id');
            return view('Operational.ticketingdetail',compact('ticket','available_salespoints','budget_category_items','vendors'));
        }else{
            return back()->with('error','Form tidak ditemukan');
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
            return view('Operational.ticketingdetail',compact('available_salespoints','budget_category_items','vendors'));
        }else{
            return back()->with('error','Terjadi Kesalahan silahakan mencoba lagi');
        }
    }

    public function addTicket(Request $request){
        // add ticket save ticket as a draft (no validation)
        try {
            DB::beginTransaction();
            if(!isset($request->salespoint)){
                return back()->with('error','Salespoint harus dipilih');
            }
            $ticket = Ticket::find($request->id);
            $isnew = true;
            if($ticket == null){
                $newTicket = new Ticket;
                $count_ticket = Ticket::whereBetween('created_at', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ])->withTrashed()->count();
                do {
                    $code = "PCD-".now()->format('ymd').'-'.str_repeat("0", 4-strlen($count_ticket+1)).($count_ticket+1);
                    $count_ticket++;
                    $checkticket = Ticket::where('code',$code)->first();
                    ($checkticket)? $flag = false : $flag = true;
                } while (!$flag);
                $newTicket->code           = $code;
            }else{
                $newTicket = $ticket;
                $isnew = false;
            }
            $newTicket->requirement_date   = $request->requirement_date;
            $newTicket->salespoint_id      = $request->salespoint;
            $newTicket->authorization_id   = $request->authorization;
            $newTicket->item_type          = $request->item_type;
            $newTicket->request_type       = $request->request_type;
            $newTicket->budget_type        = $request->budget_type;
            $newTicket->reason             = $request->reason;
            $newTicket->save();
            $salespoint = $newTicket->salespoint;

            // ticket items
            if(isset($request->item)){
                foreach($request->item as $item) {
                    $newTicketItem                        = new TicketItem;
                    $newTicketItem->ticket_id             = $newTicket->id;
                    $newTicketItem->budget_pricing_id     = $item['id'];
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
                            $file = explode('base64,',$attachment['file'])[1];
                            $path = "/attachments/ticketing/barangjasa/".$newTicket->code.'/'.$attachment['filename'];
                            Storage::disk('local')->put($path, base64_decode($file));
                            $newAttachment->path = $path;
                            $newAttachment->save();
                        }
                    }
                }
            }

            // ticket vendor
            if(isset($request->vendor)){
                foreach ($request->vendor as $list){
                    $vendor = Vendor::find($list['id']);
                    $newTicketVendor = new TicketVendor;
                    $newTicketVendor->ticket_id         = $newTicket->id;
                    if($vendor){
                        $newTicketVendor->vendor_id     = $vendor->id;
                        $newTicketVendor->name          = $vendor->name;
                        $newTicketVendor->salesperson   = $vendor->salesperson;
                        $newTicketVendor->phone         = $vendor->phone;
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
            $authorizations = Authorization::find($request->authorization);
            if(isset($authorizations)){
                foreach($authorizations->authorization_detail as $detail){
                    $newTicketAuthorization                     = new TicketAuthorization;
                    $newTicketAuthorization->ticket_id          = $newTicket->id;
                    $newTicketAuthorization->employee_id        = $detail->employee_id;
                    $newTicketAuthorization->employee_name      = $detail->employee->name;
                    $newTicketAuthorization->as                 = $detail->sign_as;
                    $newTicketAuthorization->employee_position  = $detail->employee->employee_position->name;
                    $newTicketAuthorization->level              = $detail->level;
                    $newTicketAuthorization->save();
                }
            }
            DB::commit();
            if($isnew){
                return redirect('/ticketing')->with('success','Berhasil menambah form pengadaan '.$newTicket->code.'. Silahkan melakukan review kembali');
            }else{
                return redirect('/ticketing')->with('success','Berhasil update form pengadaan');
            }
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menyimpan tiket "'.$ex->getMessage().'"');
        }
    }

    public function startAuthorization(Request $request){
        try{
            $ticket = Ticket::findOrFail($request->ticket_id);
            $updated_at = new Carbon($request->updated_at);
            if($updated_at == $ticket->updated_at){
                $ticket->status = 1;
                $ticket->save();
                return back()->with('success','Berhasil memulai otorisasi');
            }else{
                return back()->with('error','Ticket sudah memulai otorisasi');
            }
        }catch (\Exception $ex){
            return back()->with('error','Gagal memulai otorisasi '.$ex->getMessage());
        }
    }

    public function approveTicket(Request $request){
        try{
            $ticket = Ticket::findOrFail($request->ticket_id);
            $updated_at = new Carbon($request->updated_at);
            if ($updated_at == $ticket->updated_at) {
                $authorization = $ticket->current_authorization();
                if($authorization->employee_id == Auth::user()->id){
                    // set status jadi approve
                    $authorization->status = 1;
                    $authorization->save();
                    $this->checkTicketApproval($ticket->id);
                    return back()->with('success','Berhasil melakukan approve ticket');
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
            $ticket = Ticket::findOrFail($request->ticket_id);
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
