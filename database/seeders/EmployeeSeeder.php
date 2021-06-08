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
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
        }

        // AREA EMPLOYEE
        $area_employees = ['Kevin','Julian','Hafid Fauzi'];
        $usernames = ['area1','area2','area3'];
        foreach ($area_employees as $key => $area_employee){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
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
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
        }

        // PURCHASING EMPLOYEE
        $purchasing_employees = ['Deny Rachmat','Anugrah Purnama','Tirani Susanti'];
        $usernames = ['purchasing1','purchasing2','purchasing3'];
        foreach ($purchasing_employees as $key => $purchasing_employee){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
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

        // PR Position
        $positions = ['NOM','NFAM','Head Of Ops','CM'];
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
        }

        // PR Employee
        $pr_employees = ["James Arthur","windy","Yulita Adrianto ","Hafid Fauzi Sophian"];
        $usernames = ['pr1','pr2','pr3','pr4'];
        foreach ($pr_employees as $key => $pr_employee){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $pr_employee;
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
            $access->operational = 5;
            $access->save();
        }
    }
}
