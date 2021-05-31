<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingAuthorization extends Model
{
    protected $table = 'bidding_authorization';
    protected $primaryKey = 'id';

    public function bidding(){
        $this->belongsTo(Bidding::class);
    }

    public function employee(){
        $this->belongsTo(Employee::class);
    }
}
