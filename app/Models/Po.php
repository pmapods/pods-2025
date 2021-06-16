<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\POUploadRequest;

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

    public function po_authorization(){
        return $this->hasMany(PoAuthorization::class);
    }

    public function po_upload_request(){
        return POUploadRequest::where('status','!=',-1)->where('isExpired',false)->first();
    }
}
