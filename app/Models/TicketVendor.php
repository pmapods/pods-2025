<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TicketVendor extends Model
{
    use SoftDeletes;
    protected $table = 'ticket_vendor';
    protected $primaryKey = 'id';
    
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
