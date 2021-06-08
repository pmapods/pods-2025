<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PrDetail extends Model
{
    use SoftDeletes;
    protected $table = 'pr_detail';
    protected $primaryKey = 'id';

    public function pr(){
        return $this->belongsTo(Pr::class);
    }

    public function ticket_item(){
        return $this->belongsTo(TicketItem::class);
    }
}
