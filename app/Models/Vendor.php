<?php

namespace App\Models;

use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use softDeletes;
    protected $table = 'vendor';
    protected $primaryKey = 'id';

    public function regency(){
        return $this->belongsTo(Regency::class,'city_id','id');
    }

    public function status_name(){
        switch ($this->status){
            case '0':
                return 'Aktif';
                break;
            case '1':
                return 'Non Aktif';
                break;
            default:
                return 'status_undefined';
                break;
        }
    }
}
