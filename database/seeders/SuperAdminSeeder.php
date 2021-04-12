<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;
use App\Models\Employee;
use Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // tambah kategori SuperAdmin
        $employeeposition           = new EmployeePosition;
        $employeeposition->name     = 'Super Admin';
        $employeeposition->save();

        // tambah satu user super admin
        $employee                         = new Employee;
        $employee->employee_position_id   = $employeeposition->id;
        $employee->code                   = 'EMP-00001';
        $employee->name                   = 'Admin';
        $employee->username               = 'superadmin';
        $employee->password               =  Hash::make('superadmin');
        $employee->email                  = 'pma_purchasing@pinusmerahabadi.co.id';
        $employee->phone                  = '08123456789';
        $employee->save();
    }
}
