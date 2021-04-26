<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAuthorization extends Model
{
    protected $table = 'ticket_authorization';
    protected $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
