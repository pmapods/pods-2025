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

    public function budget_detail(){
        switch ($this->type) {
            case 'inventory':
                return $this->hasMany(InventoryBudget::class);
                break;
            
            case 'armada':
                return $this->hasMany(ArmadaBudget::class);
                break;
            
            case 'assumption':
                return $this->hasMany(AssumptionBudget::class);
                break;
            default:
                break;
        }
    }

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id');
    }

    public function rejected_by_employee(){
        return $this->belongsTo(Employee::class,'rejected_by','id');
    }

    public function current_authorization(){
        $queue = $this->authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status == 1){
            // authorization done
            return null;
        }else{
            return $current;
        }
    }

    public function status(){
        // dd($this->status);
        switch ($this->status) {
            case '0':
                return 'Menunggu Otorisasi '.$this->current_authorization()->employee_name;
                break;
            
            case '1':
                return 'Aktif';
                break;
            
            case '2':
                return 'Non Aktif / Expired';
                break;
                
            case '-1':
                return 'Ditolak Oleh '.$this->rejected_by_employee->name;
                break;
            
            default:
                return 'item_type_undefined';
                break;
        }
    }
}
