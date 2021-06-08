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
        return $this->hasMany(Authorizations::class);
    }

    public function pr_logs(){
        return $this->hasMany(PrLog::class);
    }
}
