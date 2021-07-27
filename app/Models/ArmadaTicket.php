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
        return ArmadaType::find($this->armada_type_id);
    }

    public function pr(){
        return $this->hasOne(Pr::class);
    }

    public function po(){
        return $this->hasMany(Po::class);
    }

    public function authorizations(){
        return $this->hasMany(ArmadaTicketAuthorization::class);
    }

    public function current_authorization(){
        $queue = $this->authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status >= 2){
            // authorization done
            return null;
        }else{
            return $current;
        }
    }

    public function armada(){
        return Armada::find($this->armada_id);
    }

    public function status(){
        switch ($this->status) {
            case '0':
                return 'Pengadaan Baru';
                break;
            
            case '1':
                return 'Dalam proses otorisasi';
                break;
            
            case '2':
                return 'Menunggu Proses PR';
                break;

            case '3':
                return 'Memulai Otorisasi PR';
                break;

            case '4':
                return 'Otorisasi PR selesai. Menunggu Nomor Asset';
                break;

            case '5':
                return 'PR selesai. Menunggu proses PO';
                break;
            case '-1':
                return 'Batal';
                break;
            
            default:
                return 'item_type_undefined';
                break;
        }
        
            // -1 Terminated
            // 0 New
            // 1 Pending Authorization
            // 2 Finish Authorization
            // 3 Otorisasi PR Dimulai
            // 4 Otorisasi Selesai
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

    public function facility_form(){
        return $this->hasOne(FacilityForm::class);
    }
    
    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id')->withTrashed();
    }

    public function terminated_by_employee(){
        return $this->belongsTo(Employee::class,'terminated_by','id')->withTrashed();
    }
}
