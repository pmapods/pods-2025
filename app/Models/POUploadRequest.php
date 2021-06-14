<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class POUploadRequest extends Model
{
    protected $table = 'po_upload_request';
    protected $primaryKey = 'id';

    public function po(){
        return $this->belongsTo(Po::class);
    }
}
