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
        return $this->belongsTo(Armada::class)->withTrashed();
    }

    public function authorizations(){
        return $this->hasMany(PerpanjanganFormAuthorization::class);
    }

    public function terminated_by_employee(){
        return $this->belongsTo(Employee::class,'terminated_by','id')->withTrashed();
    }

    public function current_authorization(){
        $queue = $this->authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        if($this->status != 0){
            // authorization done
            return null;
        }else{
            return $current;
        }
    }
    
    public function getPath(){
        $code = $this->armada_ticket->code;
        if($code){
            $data = app('app\Http\Controllers\Operational\ArmadaTicketingController')->printPerpanjanganForm($code,'path');
            return $data;
        }else{
            return null;
        }
    }
}
