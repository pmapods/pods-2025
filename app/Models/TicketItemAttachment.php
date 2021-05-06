<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketItemAttachment extends Model
{
    protected $table = 'ticket_item_attachment';
    protected $primaryKey = 'id';

    public function ticket_item(){
        return $this->belongsTo(TicketItem::class);
    }
}
