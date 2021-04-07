<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetPricingCategory extends Model
{
    protected $table = 'budget_pricing_category';
    protected $primaryKey = 'id';

    public function budget_pricing(){
        return $this->hasMany(BudgetPricing::class);
    }
}
