<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationDetail extends Model
{
    protected $table = 'authorization_detail';
    protected $primaryKey = 'id';

    public function authorization(){
        return $this->belongsTo(AuthorizationDetail::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
