<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class TicketItemFileRequirement extends Model
{
    protected $table = 'ticket_item_file_requirement';
    protected $primaryKey = 'id';

    public function ticket_item(){
        return $this->belongsTo(TicketItem::class);
    }
    public function file_completement(){
        return $this->belongsTo(FileCompletement::class);
    }
    public function rejected_by_employee(){
        if($this->rejected_by != null){
            return Employee::find($this->rejected_by);
        }else{
            return null;
        }
    }
}
