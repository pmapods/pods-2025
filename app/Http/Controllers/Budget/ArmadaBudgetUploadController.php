<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;
use App\Models\Authorization;
use App\Models\ArmadaBudget;
use App\Models\BudgetUpload;
use App\Models\BudgetUploadAuthorization;

class ArmadaBudgetUploadController extends Controller
{
    public function armadaBudgetView(){
        
        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');

        $budgets = BudgetUpload::whereIn('salespoint_id',$user_location_access)->where('type','armada')->get();
        return view('Budget.Armada.armadabudget',compact('budgets'));
    }

    public function armadaBudgetDetailView($budget_upload_code){
        $budget = BudgetUpload::where('code', $budget_upload_code)->first();
        if($budget == null){
            return redirect('/armadabudget')->with('error','Kode budget tidak tersedia.');
        }else{
            return view('Budget.Armada.armadabudgetdetail',compact('budget'));
        }
    }

    public function addArmadaBudgetView(){
        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');
        return view('Budget.Armada.addarmadabudget',compact('available_salespoints'));
    }

    public function createBudgetRequest(Request $request){
        try {
            DB::beginTransaction();

            // check apakah ada request budget armada yang masih pending request
            
            $is_pending_request = BudgetUpload::where('status',0)->where('type','armada')->first();
            if($is_pending_request){
                return back()->with('error','Harap menyelesaikan request budget armada sebelumnya terlebih dahulu. dengan kode request '.$is_pending_request->code);
            }
            $budget_request_count = BudgetUpload::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->where('salespoint_id',$request->salespoint_id)
            ->withTrashed()
            ->count();
            $salespoint = Salespoint::find($request->salespoint_id)->first();
            
            do {
                $code = "BUDGET-ARM-".$salespoint->initial."-".now()->translatedFormat('ymd').'-'.str_repeat("0", 3-strlen($budget_request_count+1)).($budget_request_count+1);
                $checkbudget = BudgetUpload::where('code',$code)->first();
                ($checkbudget != null) ? $flag = false : $flag = true;
            } while (!$flag);

            // set old budget status to non active
            $oldbudget = BudgetUpload::where('type','armada')
                ->where('salespoint_id',$request->salespoint_id)
                ->whereIn('status',[-1,0,1])
                ->first();
            if($oldbudget){
                $oldbudget->status         = -1;
                $oldbudget->reject_notes   = "Overwrite dengan budget baru ".$code;
                $oldbudget->rejected_by    = Auth::user()->id;
                $oldbudget->save();
                $oldbudget->delete();
            }

            $newBudget                       = new BudgetUpload;
            $newBudget->salespoint_id        = $request->salespoint_id;
            $newBudget->type                 = 'armada';
            $newBudget->code                 = $code;
            $newBudget->status               = 0;
            $newBudget->created_by           = Auth::user()->id;
            $newBudget->save();

            foreach($request->item as $item){
                $newArmadaBudget                   = new ArmadaBudget;
                $newArmadaBudget->budget_upload_id = $newBudget->id;
                $newArmadaBudget->type_armada      = $item['type_armada'];
                $newArmadaBudget->vendor           = $item['vendor'];
                $newArmadaBudget->qty              = $item['qty'];
                $newArmadaBudget->value            = $item['value'];
                $newArmadaBudget->amount           = $item['amount'];
                $newArmadaBudget->save();
            }

            $authorization = Authorization::findOrFail($request->authorization_id);
            foreach ($authorization->authorization_detail as $key => $authorization) {
                $newAuthorization                    = new BudgetUploadAuthorization;
                $newAuthorization->budget_upload_id  = $newBudget->id;
                $newAuthorization->employee_id       = $authorization->employee_id;
                $newAuthorization->employee_name     = $authorization->employee->name;
                $newAuthorization->as                = $authorization->sign_as;
                $newAuthorization->employee_position = $authorization->employee_position->name;
                $newAuthorization->level             = $key+1;
                $newAuthorization->save();
            }

            // recall the new one
            $authorization = $newBudget->current_authorization();
            DB::commit();
            return redirect('/armadabudget/'.$code)->with('success','Berhasil membuat request upload budget, otorisasi saat ini oleh '.$authorization->employee_name);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

    public function reviseBudget(Request $request){
        try {
            DB::beginTransaction();
            $budget                 = BudgetUpload::findOrFail($request->upload_budget_id);
            $budget->status         = 0;
            $budget->created_by     = Auth::user()->id;
            $budget->created_at     = now();
            $budget->save();

            // get pending item from old budget
            $pendingitems = [];
            foreach($budget->budget_detail as $b){
                if($b->pending_quota > 0){
                    $pendingitem  = new \stdClass();
                    $pendingitem->type_armada = $b->type_armada;
                    $pendingitem->vendor = $b->vendor;
                    $pendingitem->pending_quota = $b->pending_quota;
                    $pendingitem->isSelected = false;
                    array_push($pendingitems,$pendingitem);
                }
            }
            $pendingitems = collect($pendingitems);
            foreach ($budget->budget_detail as $b){
                $b->delete();
            }

            // masukin budget baru dari request
            foreach($request->item as $item){
                $newArmadaBudget                   = new ArmadaBudget;
                $newArmadaBudget->budget_upload_id = $budget->id;
                $newArmadaBudget->type_armada      = $item['type_armada'];
                $newArmadaBudget->vendor           = $item['vendor'];
                $newArmadaBudget->qty              = $item['qty'];
                $newArmadaBudget->value            = $item['value'];
                $newArmadaBudget->amount           = $item['amount'];

                // check apakah di budget sebelumnya ada pending Amount
                $olditem = $pendingitems->where('type_armada',$newArmadaBudget->type_armada)->where('vendor',$newArmadaBudget->vendor)->first();
                if($olditem != null){
                    // check apakah jumlah budget baru lebih besar dari pada pending
                    if($newArmadaBudget->qty < $olditem->pending_quota){
                        // reject
                        return back()->with('error','Armada '.$newArmadaBudget->type_armada.'dengan vendor '.$newArmadaBudget->vendor.' memiliki '.$olditem->pending_quota.' dalam status Pending. Budget baru harus lebih besar dari jumlah item yang sedang pending');
                    }else{
                        // accept
                        $newArmadaBudget->pending_quota = $olditem->pending_quota;
                        $olditem->isSelected = true;
                    }
                }
                $newArmadaBudget->save();
            }

            // reset otorisasi
            foreach($budget->authorizations as $authorization){
                $authorization->status = 0;
                $authorization->save();
            }
            
            // check apakah semua pending items sudah ke select, kalo ada yang tidak ke select return error
            foreach($pendingitems as $pendingitem){
                if($pendingitem->isSelected == false){
                    return back()->with('error','Armada '.$pendingitem->type_armada.' dengan memiliki pending kuota yang sedang dalam proses. Silahkan menambahkan Armada '.$pendingitem->type_armada.' dengan vendor '.$pendingitem->vendor.' sejumlah minimal'.$pendingitem->pending_quota.' ke dalam revisi budget');
                }
            }

            $current_authorization = $budget->current_authorization();
            DB::commit();
            return redirect('/armadabudget/'.$budget->code)->with('success','Berhasil membuat revisi upload budget, otorisasi saat ini oleh '.$current_authorization->employee_name);
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

    public function terminateBudget(Request $request){
        try {
            DB::beginTransaction();

            $budget                 = BudgetUpload::findOrFail($request->budget_upload_id);
            $budget->status         = -1;
            $budget->reject_notes   = $request->reason;
            $budget->rejected_by    = Auth::user()->id;
            $budget->save();
            $budget->delete();

            foreach ($budget->budget_detail as $b){
                $b->delete();
            }

            DB::commit();
            return redirect('/armadabudget')->with('success','Berhasil membatalkan pengadaan upload budget');
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
        }
    }

    public function approveBudgetAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $budget = BudgetUpload::findOrFail($request->budget_upload_id);
            $current_authorization = $budget->current_authorization();
            if($current_authorization->employee_id != Auth::user()->id){
                return back()->with('error','Otorisasi saat ini tidak sesuai dengan akun login.');
            }else{
                $current_authorization->status += 1;
                $current_authorization->save();
            }

            $current_authorization = $budget->current_authorization();
            if($current_authorization == null){
                $budget->status = 1;
                $budget->save();
                DB::commit();
                return back()->with('success','Otorisasi request budget '.$budget->code.' telah selesai. Status Budget sudah aktif');
            }else{
                DB::commit();
                return back()->with('success','Berhasil melakukan approval otorisasi request budget '.$budget->code.'. Otorisasi selanjutnya oleh '.$current_authorization->employee_name);
            }
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return back()->with('error','Gagal melakukan otorisasi '.$ex->getMessage());
        }
    }

    public function rejectBudgetAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $budget = BudgetUpload::findOrFail($request->budget_upload_id);
            $current_authorization = $budget->current_authorization();
            if($current_authorization->employee_id != Auth::user()->id){
                return back()->with('error','Otorisasi saat ini tidak sesuai dengan akun login.');
            }
            
            $budget->status = -1;
            $budget->rejected_by = Auth::user()->id;
            $budget->reject_notes = $request->reason;
            $budget->save();

            // reset all authorization
            foreach($budget->authorizations as $authorization){
                $authorization->status = 0;
                $authorization->save();
            }

            DB::commit();
            return back()->with('success','Berhasil menolak request budget '.$budget->code.' dengan alasan '.$request->reason);
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menolak request budget '.$ex->getMessage());
        }
    }

    public function getBudgetAuthorizationbySalespoint($salespoint_id){
        $budget_authorizations = Authorization::where('salespoint_id',$salespoint_id)->where('form_type',10)->get();

        foreach($budget_authorizations as $authorizations){
            $authorizations->list = $authorizations->authorization_detail;
            foreach($authorizations->list as $item){
                $item->employee_name = $item->employee->name;
            }
        }
        return response()->json([
            'data' => $budget_authorizations,
        ]);
    }

    public function getActiveSalespointBudget(Request $request){
        $budget = BudgetUpload::where('type',$request->type)
                ->where('salespoint_id',$request->salespoint_id)
                ->whereIn('status',[-1,0,1])
                ->first();
        $budget->status = $budget->status();
        $budget->period = $budget->created_at->translatedFormat('F Y');
        $data = [
            "budget" => $budget,
            "lists" => $budget->budget_detail,
        ];
        return response()->json([
            "data" => $data
        ]);
    }
}
