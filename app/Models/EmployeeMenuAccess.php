<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMenuAccess extends Model
{
    protected $table = 'employee_menu_access';
    protected $primaryKey = 'id';

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
