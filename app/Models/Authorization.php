<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table = 'authorization';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function authorization_detail(){
        return $this->hasMany(AuthorizationDetail::class);
    }

    public function form_type_name(){
        switch ($this->form_type) {
            case 0:
                return 'Form Pengadaan';
                break;
            
            default:
                return 'form_type_undefined';
                break;
        }
    }
}
