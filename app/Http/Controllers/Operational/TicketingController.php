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
use App\Models\TicketItems;
use App\Models\TicketVendor;
use App\Models\TicketAuthorization;
use App\Models\Authorization;
use Auth;
use DB;
use Carbon\Carbon;

class TicketingController extends Controller
{
    public function ticketingView(){
        $user_location_access = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');
        
        $budget_category_items = BudgetPricingCategory::all();

        // active vendors
        $vendors = Vendor::where('status',0)->get();

        // show ticket liat based on auth access area
        $access = Auth::user()->location_access->pluck('salespoint_id');
        $tickets = Ticket::whereIn('salespoint_id',$access)->get()->sortByDesc('created_at');
        return view('Operational.ticketing',compact('available_salespoints','budget_category_items','vendors','tickets'));
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
        try {
            DB::beginTransaction();
            $newTicket                     = new Ticket;
            $newTicket->requirement_date   = $request->requirement_date;
            $newTicket->salespoint_id      = $request->salespoint_select2;
            $newTicket->authorization_id   = $request->authorization_select2;
            $newTicket->item_type          = $request->item_type;
            $newTicket->request_type       = $request->request_type;
            $newTicket->budget_type        = $request->budget_type;
            $newTicket->reason             = $request->reason;
            $newTicket->created_by         = Auth::user()->id;
            if($request->type == 1){
                $newTicket->status = 1;
            }
            $newTicket->save();
            $salespoint = $newTicket->salespoint;

            // ticket items
            foreach($request->item as $item) {
                $newTicketItems                    = new TicketItems;
                $newTicketItems->ticket_id         = $newTicket->id;
                $budget                            = BudgetPricing::find($item['id']);
                if($budget){
                    $newTicketItems->budget_pricing_id     = $budget->id;
                    $newTicketItems->name                  = $budget->name;
                    if($salespoint->isJawaSumatra){
                        $newTicketItems->min_price         = $budget->injs_min_price;
                        $newTicketItems->max_price         = $budget->injs_max_price;
                    }else{
                        $newTicketItems->min_price         = $budget->outjs_min_price;
                        $newTicketItems->max_price         = $budget->outjs_max_price;
                    }
                }else{
                    $newTicketItems->budget_pricing_id     = null;
                    $newTicketItems->name                  = $item['name'];
                    $newTicketItems->min_price             = null;
                    $newTicketItems->max_price             = null;
                }
                $newTicketItems->brand             = $item['brand'];
                $newTicketItems->price             = $item['price'];
                $newTicketItems->count             = $item['count'];
                $newTicketItems->save();
            }

            // ticket vendor
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

            // ticket authorization
            $authorizations = Authorization::findOrFail($request->authorization_select2);
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
            DB::commit();
            return back()->with('success','Berhasil menambah form pengadaan. Silahkan melakukan review kembali');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menambah tiket "'.$ex->getMessage().'"');
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
