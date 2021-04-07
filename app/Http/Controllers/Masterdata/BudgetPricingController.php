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
}
