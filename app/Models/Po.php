<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\POUploadRequest;

class Po extends Model
{
    protected $table = 'po';
    protected $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function po_detail(){
        return $this->hasMany(PoDetail::class);
    }

    public function ticket_vendor(){
        return $this->belongsTo(TicketVendor::class);
    }

    public function created_by_employee(){
        return $this->belongsTo(Employee::class,'created_by','id');
    }

    public function po_authorization(){
        return $this->hasMany(PoAuthorization::class);
    }

    public function po_upload_request(){
        return $this->hasOne(PoUploadRequest::class,'id','po_upload_request_id');
    }
}
