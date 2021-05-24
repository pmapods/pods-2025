<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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
}
