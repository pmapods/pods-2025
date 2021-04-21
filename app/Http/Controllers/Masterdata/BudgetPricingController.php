<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BudgetPricing;
use App\Models\BudgetPricingCategory;

class BudgetPricingController extends Controller
{
    public function budgetpricingView(){
        $budget_categories = BudgetPricingCategory::all();
        $budgets = BudgetPricing::all();
        return view('Masterdata.budgetpricing',compact('budget_categories', 'budgets'));
    }

    public function addBudget(Request $request){
        try {
            $category = BudgetPricingCategory::findOrFail($request->budget_pricing_category_id);
            $count_items = $category->budget_pricing_with_trashed->count() + 1;
            $code = $category->code."-".str_repeat("0", 2-strlen($count_items)).$count_items;

            $newBudget = new BudgetPricing();
            $newBudget->budget_pricing_category_id = $request->budget_pricing_category_id;
            $newBudget->code = $code;
            $newBudget->name = $request->name;
            $newBudget->brand = $request->brand;
            $newBudget->type = $request->type;
            $newBudget->injs_min_price = ($request->injs_min_price > 0) ? $request->injs_min_price : null;
            $newBudget->injs_max_price = ($request->injs_max_price > 0) ? $request->injs_max_price : null;
            $newBudget->outjs_min_price = ($request->outjs_min_price > 0) ? $request->outjs_min_price : null;
            $newBudget->outjs_max_price = ($request->outjs_max_price > 0) ? $request->outjs_max_price : null;
            $newBudget->save();

            return back()->with('success','Berhasil menambah budget');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambah budget "'.$ex->getMessage().'"');
        }
    }
    
    public function updateBudget(Request $request){
        try {
            $budget = BudgetPricing::findOrFail($request->id);
            $budget->brand = $request->brand;
            $budget->type = $request->type;
            $budget->injs_min_price = ($request->injs_min_price > 0) ? $request->injs_min_price : null;
            $budget->injs_max_price = ($request->injs_max_price > 0) ? $request->injs_max_price : null;
            $budget->outjs_min_price = ($request->outjs_min_price > 0) ? $request->outjs_min_price : null;
            $budget->outjs_max_price = ($request->outjs_max_price > 0) ? $request->outjs_max_price : null;
            $budget->save();
            
            return back()->with('success','Berhasil mengubah budget');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambah budget "'.$ex->getMessage().'"');
        }
    }

    public function deleteBudget(Request $request){
        try {
            $budget = BudgetPricing::findOrFail($request->id);
            $budget->delete();
            return back()->with('success','Berhasil menghapus budget');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambah budget "'.$ex->getMessage().'"');
        }
    }
}
