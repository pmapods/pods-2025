<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EvaluasiForm extends Model
{
    use SoftDeletes;
    protected $table = 'evaluasi_form';
    protected $primaryKey = 'id';

    public function authorizations(){
        return $this->hasMany(EvaluasiFormAuthorization::class);
    }

    public function current_authorization(){
        $queue = $this->authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status >= 2){
            // authorization done
            return null;
        }else{
            return $current;
        }
    }

}
