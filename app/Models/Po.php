<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $table = 'po';
    protected $primaryKey = 'id';

    public function ticket_vendor(){
        return $this->belongsTo(TicketVendor::class);
    }

    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id');
    }
}
