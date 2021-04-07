<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employee';
    protected $primaryKey = 'id';

    public function location_access(){
    	return $this->hasMany(EmployeeLocationAccess::class);
    }
}
