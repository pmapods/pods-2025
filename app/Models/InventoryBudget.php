<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InventoryBudget extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'inventory_budget';

    public function budget_upload(){
        return $this->belongsTo(BudgetUpload::class);
    }
}
