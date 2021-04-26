<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TicketItems extends Model
{
    use SoftDeletes;
    protected $table = 'ticket_items';
    protected $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
