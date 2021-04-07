<?php

namespace App\Models;

use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Model;

class BudgetPricing extends Model
{
    use softDeletes;
    protected $table = 'budget_pricing';
    protected $primaryKey = 'id';

    public function budget_pricing_category(){
        return $this->belongsTo(BudgetPricingCategory::class);
    }
}
