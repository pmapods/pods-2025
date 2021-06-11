<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class TicketItem extends Model
{
    use SoftDeletes;
    protected $table = 'ticket_item';
    protected $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function ticket_item_attachment(){
        return $this->hasMany(TicketItemAttachment::class);
    }

    public function ticket_item_file_requirement(){
        return $this->hasMany(TicketItemFileRequirement::class);
    }

    public function budget_pricing(){
        // hanya untuk barang terdaftar
        return $this->belongsTo(BudgetPricing::class);
    }

    public function pr_detail(){
        return $this->hasOne(PrDetail::class);
    }

    public function cancelled_by_employee(){
        if($this->cancelled_by){
            return Employee::find($this->cancelled_by);
        }else{
            return null;
        }
    }

    public function isFilesChecked(){
        $flag = true;
        foreach($this->ticket_item_attachment as $attachment){
            if($attachment->status != 1){
                $flag = false;
            }
        }
        foreach($this->ticket_item_file_requirement as $requirement){
            if($requirement->status != 1){
                $flag = false;
            }
        }
        return $flag;
    }

    public function bidding(){
        return $this->hasOne(Bidding::class);
    }

    public function selected_po(){
        return $this->bidding->selected_vendor()->ticket_vendor->po;
    }
}
