<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PerpanjanganForm extends Model
{
    use SoftDeletes;
    protected $table = 'perpanjangan_form';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function armada_ticket(){
        return $this->belongsTo(ArmadaTicket::class);
    }

    public function armada(){
        return $this->belongsTo(Armada::class);
    }

    public function authorizations(){
        return $this->hasMany(FacilityFormAuthorization::class);
    }

    public function current_authorization(){
        $queue = $this->authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status == 1){
            // authorization done
            return null;
        }else{
            return $current;
        }
    }
}
