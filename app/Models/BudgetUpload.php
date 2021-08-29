<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BudgetUpload extends Model
{
    use SoftDeletes;
    protected $table = 'budget_upload';
    protected $primaryKey = 'id';

    public function authorizations(){
        return $this->hasMany(BudgetUploadAuthorization::class);
    }

    public function inventory_budgets(){
        return $this->hasMany(InventoryBudget::class,'inventory_budget_id','id');
    }
}
