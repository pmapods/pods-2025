<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArmadaTicket extends Model
{
    use SoftDeletes;
    protected $table = 'armada_ticket';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function armada_type(){
        return $this->belongsTo(ArmadaType::class);
    }

    public function status(){
        switch ($this->status) {
            case '0':
                return 'Pengadaan Baru';
                break;
                
            case '-1':
                return 'Batal';
                break;
            
            default:
                return 'item_type_undefined';
                break;
        }
    }

    public function type(){
        switch ($this->ticketing_type) {
            case '0':
                return 'Pengadaan Baru';
                break;
            case '1':
                return 'Perpanjangan/Replace/Renewal/Stop Sewa';
                break;
            case '2':
                return 'Mutasi';
                break;
            case '3':
                return 'COP';
                break;
            case '-1':
                return 'Batal';
                break;
            default:
                return 'item_type_undefined';
                break;
        }
    }

    
    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id')->withTrashed();
    }

    public function terminated_by_employee(){
        return $this->belongsTo(Employee::class,'terminated_by','id')->withTrashed();
    }
}
