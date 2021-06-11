<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
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

    public function pr(){
        return $this->hasOne(Pr::class);
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
                return 'Bidding Selesai / Menunggu Proses PR';
                break;

            case '4':
                return 'PR sudah dibuat, Menunggu otorisasi';
                break;

            case '5':
                return 'PR selesai otorisasi, Menunggu update kelengkapan nomor asset';
                break;

            case '6':
                return 'PR selesai. Menunggu proses PO';
                break;
                
            case '7':
                return 'Closed PO';
                break;
                
            case '-1':
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

    public function ticket_items_with_attachments(){
        $data = array();
        foreach($this->ticket_item as $item){
            $item->attachments = $item->ticket_item_attachment;
            $item->files = $item->ticket_item_file_requirement;
            array_push($data,$item);
        }
        return $data;
    }
    
    public function ticket_vendors_with_additional_data(){
        $data = array();
        foreach($this->ticket_vendor as $ticket_vendor){
            if(isset($ticket_vendor->vendor()["code"])){
                $ticket_vendor->code = $ticket_vendor->vendor()["code"];
                $ticket_vendor->vendor_id = $ticket_vendor->vendor()["id"];
            }else{
                $ticket_vendor->code = null;
                $ticket_vendor->vendor_id = null;
            }
            array_push($data,$ticket_vendor);
        }
        return $data;
    }

    public function ba_rejected_by_employee(){
        if($this->ba_rejected_by != null){
            return Employee::find($this->ba_rejected_by);
        }else{
            return null;
        }
    }
    public function ba_revised_by_employee(){
        if($this->ba_rejected_by != null){
            return Employee::find($this->ba_revised_by);
        }else{
            return null;
        }
    }
    public function ba_confirmed_by_employee(){
        if($this->ba_confirmed_by != null){
            return Employee::find($this->ba_confirmed_by);
        }else{
            return null;
        }
    }

}
