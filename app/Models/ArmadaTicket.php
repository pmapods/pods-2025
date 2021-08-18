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
        return $this->belongsTo(ArmadaType::class,'armada_type_id','id');
    }

    public function armada(){
        return $this->belongsTo(Armada::class,'armada_id','id')->withTrashed();
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
                if (in_array($this->type(),['Pengadaan','Replace','Renewal'])){
                    return 'Menunggu Upload Berkas Penerimaan';
                }else{
                    return 'Menunggu Upload Berkas Penyerahan';
                }
                break;

            case '6':
                return 'Pengadaan Armada Selesai';
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
            case 0:
                return 'Pengadaan';
                break;
            case 1:
                switch ($this->perpanjangan_form->form_type ?? 'unset') {
                    case 'perpanjangan':
                        return 'Perpanjangan';
                        break;
                    
                    case 'stopsewa':
                        switch ($this->perpanjangan_form->stopsewa_reason) {
                            case 'replace':
                                return 'Replace';
                                break;
                            case 'renewal':
                                return 'Renewal';
                                break;
                            case 'end':
                                return 'End Kontrak';
                                break;
                        }
                        break;
                    default:
                        return 'Perpanjangan/Replace/Renewal/End Kontrak';
                        break;
                }   
                break;
            case 2:
                return 'Mutasi';
                break;
        }
    }

    public function facility_form(){
        return $this->hasOne(FacilityForm::class);
    }

    public function last_rejected_facility_form(){
        return $this->hasOne(FacilityForm::class)->onlyTrashed()->orderBy('id', 'desc');
    }

    public function perpanjangan_form(){
        return $this->hasOne(PerpanjanganForm::class);
    }

    public function last_rejected_perpanjangan_form(){
        return $this->hasOne(PerpanjanganForm::class)->onlyTrashed()->orderBy('id', 'desc');
    }

    public function mutasi_form(){
        return $this->hasOne(MutasiForm::class);
    }

    public function last_rejected_mutasi_form(){
        return $this->hasOne(MutasiForm::class)->onlyTrashed()->orderBy('id', 'desc');
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
}
