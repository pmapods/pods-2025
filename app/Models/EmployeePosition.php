<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class EmployeePosition extends Model
{
    use softDeletes;
    protected $table = 'employee_position';
    protected $primaryKey = 'id';

    public function employees(){
        return $this->hasMany(Employee::class);
    }
}
