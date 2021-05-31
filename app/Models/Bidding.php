<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use SoftDeletes;
    protected $table = 'bidding';
    protected $primaryKey = 'id';
    
    public function bidding_detail(){
        return $this->hasMany(BiddingDetail::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function ticket_item(){
        return $this->belongsTo(TicketItem::class);
    }
}
