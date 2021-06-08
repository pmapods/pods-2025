<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pr extends Model
{
    use SoftDeletes;
    protected $table = 'pr';
    protected $primaryKey = 'id';

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function pr_detail(){
        return $this->hasMany(PrDetail::class);
    }

    public function pr_authorizations(){
        return $this->hasMany(PrAuthorization::class);
    }

    public function pr_logs(){
        return $this->hasMany(PrLog::class);
    }

    public function current_authorization(){
        $queue = $this->pr_authorizations->where('status',0)->sortBy('level');
        $current = $queue->first();
        return $current;
    }

    public function last_authorization(){
        $queue = $this->pr_authorizations->where('status',1)->sortByDesc('level');
        if($last){
            $last = $queue->first();
        }
        if($this->status != 1){
            return null;
        }else{
            return $last;
        }
    }

    public function rejected_by_employee(){
        if($this->rejected_by != null){
            return Employee::find($this->rejected_by);
        }else{
            return null;
        }
    }
}
