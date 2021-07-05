<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;
use App\Models\Employee;
use App\Models\EmployeeLocationAccess;
use App\Models\EmployeeMenuAccess;
use App\Models\SalesPoint;
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
        $employee->code                   = 'EMP-00001';
        $employee->name                   = 'Admin';
        $employee->username               = 'superadmin';
        $employee->password               =  Hash::make('superadmin');
        $employee->email                  = 'pma_purchasing@pinusmerahabadi.co.id';
        $employee->phone                  = '08123456789';
        $employee->save();

        // kasih full akses untuk ke seluruh area
        foreach(SalesPoint::all() as $salespoint){
            $newAccess = new EmployeeLocationAccess;
            $newAccess->employee_id = $employee->id;
            $newAccess->salespoint_id = $salespoint->id;
            $newAccess->save();
        }
        
        $access = new EmployeeMenuAccess;
        $access->employee_id = $employee->id;
        $access->masterdata = 1+2+4+8+16+32+64+128+256;
        $access->operational = 15;
        $access->save();
    }
}
