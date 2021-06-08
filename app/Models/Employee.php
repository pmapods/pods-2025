<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'employee';
    protected $primaryKey = 'id';

    public function location_access(){
    	return $this->hasMany(EmployeeLocationAccess::class);
    }

    public function menu_access(){
        return $this->hasOne(EmployeeMenuAccess::class);
    }

    public function statusName(){
        switch ($this->status){
            case 0:
                return 'Aktif';
                break;
            case 1:
                return 'Non Aktif';
                break;
            default:
                return 'status_name_undefined';
                break;
        }
    }

    public function authorization_detail(){
        $this->hasMany(AuthorizationDetail::class);
    }
}
