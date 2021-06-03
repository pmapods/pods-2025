<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BudgetPricing;
use App\Models\BudgetPricingCategory;
use App\Models\BudgetBrand;
use App\Models\BudgetType;
use DB;

class BudgetPricingController extends Controller
{
    public function budgetpricingView(){
        $budget_categories = BudgetPricingCategory::all();
        $budgets = BudgetPricing::all();
        return view('Masterdata.budgetpricing',compact('budget_categories', 'budgets'));
    }

    public function addBudget(Request $request){
        try {
            DB::beginTransaction();
            $category = BudgetPricingCategory::findOrFail($request->budget_pricing_category_id);
            $count_items = $category->budget_pricing_with_trashed->count() + 1;
            $code = $category->code."-".str_repeat("0", 2-strlen($count_items)).$count_items;

            $newBudget = new BudgetPricing;
            $newBudget->budget_pricing_category_id = $request->budget_pricing_category_id;
            $newBudget->code                       = $code;
            $newBudget->name                       = $request->name;
            $newBudget->uom                        = $request->uom;
            $newBudget->injs_min_price             = ($request->injs_min_price > 0) ? $request->injs_min_price : null;
            $newBudget->injs_max_price             = ($request->injs_max_price > 0) ? $request->injs_max_price : null;
            $newBudget->outjs_min_price            = ($request->outjs_min_price > 0) ? $request->outjs_min_price : null;
            $newBudget->outjs_max_price            = ($request->outjs_max_price > 0) ? $request->outjs_max_price : null;
            $newBudget->save();
            
            if($request->brand){
                foreach($request->brand as $brand){
                    $newBudgetBrand = new BudgetBrand;
                    $newBudgetBrand->budget_pricing_id = $newBudget->id;
                    $newBudgetBrand->name = $brand;
                    $newBudgetBrand->save();
                }
            }

            if($request->type){
                foreach($request->type as $type){
                    $newBudgetType = new BudgetType;
                    $newBudgetType->budget_pricing_id = $newBudget->id;
                    $newBudgetType->name = $type;
                    $newBudgetType->save();
                }
            }
            DB::commit();
            return back()->with('success','Berhasil menambah budget');
        } catch (Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menambah budget "'.$ex->getMessage().'"');
        }
    }
    
    public function updateBudget(Request $request){
        try {
            DB::beginTransaction();
            $budget = BudgetPricing::findOrFail($request->id);
            $budget->injs_min_price = ($request->injs_min_price > 0) ? $request->injs_min_price : null;
            $budget->injs_max_price = ($request->injs_max_price > 0) ? $request->injs_max_price : null;
            $budget->outjs_min_price = ($request->outjs_min_price > 0) ? $request->outjs_min_price : null;
            $budget->outjs_max_price = ($request->outjs_max_price > 0) ? $request->outjs_max_price : null;
            $budget->save();

            if($budget->budget_brand){
                foreach($budget->budget_brand as $brand){
                    $brand->delete();
                }
            }

            if($request->brand){
                foreach($request->brand as $brand){
                    $newBudgetBrand = new BudgetBrand;
                    $newBudgetBrand->budget_pricing_id = $budget->id;
                    $newBudgetBrand->name = $brand;
                    $newBudgetBrand->save();
                }
            }

            if($budget->budget_type){
                foreach($budget->budget_type as $type){
                    $type->delete();
                }
            }

            if($request->type){
                foreach($request->type as $type){
                    $newBudgetType = new BudgetType;
                    $newBudgetType->budget_pricing_id = $budget->id;
                    $newBudgetType->name = $type;
                    $newBudgetType->save();
                }
            }
            DB::commit();
            return back()->with('success','Berhasil mengubah budget');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal mengubah budget "'.$ex->getMessage().'"');
        }
    }

    public function deleteBudget(Request $request){
        try {
            DB::beginTransaction();
            $budget = BudgetPricing::findOrFail($request->id);
            if($budget->budget_brand){
                foreach($budget->budget_brand as $brand){
                    $brand->delete();
                }
            }
            if($budget->budget_type){
                foreach($budget->budget_type as $type){
                    $type->delete();
                 }
            }
            $budget->delete();
            DB::commit();
            return back()->with('success','Berhasil menghapus budget');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menghapus budget "'.$ex->getMessage().'"');
        }
    }
}
