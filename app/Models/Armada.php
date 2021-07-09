<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    use SoftDeletes;
    protected $table = 'armada';
    protected $primaryKey = 'id';

    public function salespoint(){
        return $this->belongsTo(SalesPoint::class);
    }

    public function armada_type(){
        return $this->belongsTo(ArmadaType::class);
    }

    public function status(){
        switch ($this->status) {
            case 0:
                return 'Available';
                break;
            
            case 1:
                return 'Booked';
                break;
            
            default:
                return 'undefined_armada_status';
                break;
        }
    }
}
