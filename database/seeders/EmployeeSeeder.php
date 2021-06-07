<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Hash;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\Salespoint;
use App\Models\EmployeeLocationAccess;
use App\Models\EmployeeMenuAccess;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        //area position
        $positions = ['Staff','ROM','GROM'];
        $position_ids = [];
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
            array_push($position_ids,$newposition->id);
        }

        // AREA EMPLOYEE
        $area_employees = ['Kevin','Julian','Hafid Fauzi'];
        $usernames = ['staff','rom','grom'];
        foreach ($area_employees as $key => $area_employee){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
            $newEmployee->employee_position_id   = $position_ids[$key];
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $area_employee;
            $newEmployee->username               = $usernames[$key];
            $newEmployee->email                  = $faker->email();
            $newEmployee->password               = Hash::make($usernames[$key]);
            $newEmployee->phone                  = $faker->phoneNumber();
            $newEmployee->is_password_changed    = true;
            $newEmployee->save();

            foreach(Salespoint::all() as $salespoint){
                $newAccess = new EmployeeLocationAccess;
                $newAccess->employee_id = $newEmployee->id;
                $newAccess->salespoint_id = $salespoint->id;
                $newAccess->save();
            }
            $access = new EmployeeMenuAccess;
            $access->employee_id = $newEmployee->id;
            $access->masterdata = 0;
            $access->operational = 1;
            $access->save();
        }

        // Purchasing position
        $positions = ['Purchasing Staff','Purchasing SPV','Purchasing Manager'];
        $position_ids = [];
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
            array_push($position_ids,$newposition->id);
        }

        // PURCHASING EMPLOYEE
        $purchasing_employees = ['Deny Rachmat','Anugrah Purnama','Tirani Susanti'];
        $usernames = ['purchasing1','purchasing2','purchasing3'];
        foreach ($purchasing_employees as $key => $purchasing_employee){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
            $newEmployee->employee_position_id   = $position_ids[$key];
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $purchasing_employee;
            $newEmployee->username               = $usernames[$key];
            $newEmployee->email                  = $faker->email();
            $newEmployee->password               = Hash::make($usernames[$key]);
            $newEmployee->phone                  = $faker->phoneNumber();
            $newEmployee->is_password_changed    = true;
            $newEmployee->save();

            foreach(Salespoint::all() as $salespoint){
                $newAccess = new EmployeeLocationAccess;
                $newAccess->employee_id = $newEmployee->id;
                $newAccess->salespoint_id = $salespoint->id;
                $newAccess->save();
            }
            $access = new EmployeeMenuAccess;
            $access->employee_id = $newEmployee->id;
            $access->masterdata = 0;
            $access->operational = 6;
            $access->save();
        }

    }
}
