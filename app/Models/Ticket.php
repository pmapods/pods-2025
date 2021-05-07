<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use SoftDeletes;
    protected $table = 'ticket';
    protected $primaryKey = 'id';

    public function ticket_item(){
        return $this->hasMany(TicketItem::class);
    }

    public function ticket_vendor(){
        return $this->hasMany(TicketVendor::class);
    }

    public function ticket_authorization(){
        return $this->hasMany(TicketAuthorization::class);
    }

    public function ticket_additional_attachment(){
        return $this->hasMany(TicketAdditionalAttachment::class);
    }

    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id');
    }

    public function salespoint(){
        return $this->belongsTo(Salespoint::class);
    }

    public function item_type(){
        switch ($this->item_type) {
            case '0':
                return 'Barang';
                break;
            case '1':
                return 'Jasa';
                break;
            
            default:
                return 'item_type_undefined';
                break;
        }
    }

    public function request_type(){
        switch ($this->request_type) {
            case '0':
                return 'Baru';
                break;
            case '1':
                return 'Replace Existing';
                break;
            
            default:
                return 'request_type_undefined';
                break;
        }
    }
    
    public function budget_type(){
        switch ($this->budget_type) {
            case '0':
                return 'Budget';
                break;
            case '1':
                return 'Non Budget';
                break;
            default:
                return 'budget_type_undefined';
                break;
        }
    }
    
    public function status(){
        switch ($this->status) {
            case '0':
                return 'Draft';
                break;
                
            case '1':
                return 'Menunggu Otorisasi';
                break;

            case '2':
                return 'Otorisasi Selesai / Menunggu Proses Bidding';
                break;
                
            case '3':
                return 'Batal';
                break;
            
            default:
                return 'item_type_undefined';
                break;
        }
    }

    public function current_authorization(){
        $queue = $this->ticket_authorization->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status != 1){
            return null;
        }else{
            return $current;
        }
    }

    public function last_authorization(){
        $queue = $this->ticket_authorization->where('status',1)->sortByDesc('level');
        if($last){
            $last = $queue->first();
        }
        if($this->status != 1){
            return null;
        }else{
            return $last;
        }
    }

    public function terminated_by_employee(){
        return $this->belongsTo(Employee::class,'terminated_by','id');
    }

}
