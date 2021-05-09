<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;

class TicketVendor extends Model
{
    use SoftDeletes;
    protected $table = 'ticket_vendor';
    protected $primaryKey = 'id';
    
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function vendor(){
        if($this->vendor_id != null){
            return Vendor::find($this->vendor_id);
        }
        return null;
    }
}
