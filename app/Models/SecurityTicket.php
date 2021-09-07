<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SecurityTicket extends Model
{
    use SoftDeletes;
    protected $table = 'security_ticket';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function authorizations(){
        return $this->hasMany(SecurityTicketAuthorization::class);
    }
    
    public function pr(){
        return $this->hasOne(Pr::class);
    }

    public function po(){
        return $this->hasMany(Po::class);
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
                return 'Menunggu proses PO';
                break;

            case '5':
                return 'Menunggu Upload Berkas dari Area';

            case '6':
                return 'Pengadaan Security Selesai';
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
            case 0:
                return 'Pengadaan Baru';
                break;
            case 1:
                return 'Perpanjangan';
                break;
            case 2:
                return 'Replace';
                break;
            case 3:
                return 'End Sewa';
                break;
            case 4:
                return 'Pengadaan Lembur';
                break;
            default:
                return 'undefined_security_type';
                break;
        }
    }

    public function po_reference(){
        return $this->belongsTo(Po::class, 'po_reference_number','no_po_sap');
    }

    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id')->withTrashed();
    }

    public function terminated_by_employee(){
        return $this->belongsTo(Employee::class,'terminated_by','id')->withTrashed();
    }

    public function evaluasi_form(){
        return $this->hasMany(EvaluasiForm::class);
    }
}
