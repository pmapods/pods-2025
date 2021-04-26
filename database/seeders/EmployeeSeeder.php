<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Hash;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\EmployeePosition;

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

        //add staff and grom
        $positions = ['Staff','ROM','GROM'];
        foreach ($positions as $position){
            $newposition = new EmployeePosition;
            $newposition->name = $position;
            $newposition->save();
        }

        $groms = ['Hafid Fauzi','Rudy Maryadin'];
        foreach ($groms as $key => $grom){
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
            $newEmployee->employee_position_id   = 4;
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $grom;
            $newEmployee->username               = 'grom'.$key;
            $newEmployee->email                  = $faker->email();
            $newEmployee->password               = Hash::make('12345678');
            $newEmployee->phone                  = $faker->phoneNumber();
            $newEmployee->save();
        }

        $count_employee = Employee::withTrashed()->count() + 1;
        $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;
        $newEmployee                         = new Employee;
        $newEmployee->employee_position_id   = 2;
        $newEmployee->code                   = $code;
        $newEmployee->name                   = 'Kevin Farel';
        $newEmployee->username               = 'staff1';
        $newEmployee->email                  = 'kevinfarel@gmail.com';
        $newEmployee->password               = Hash::make('12345678');
        $newEmployee->phone                  = $faker->phoneNumber();
        $newEmployee->save();

        $count_employee = Employee::withTrashed()->count() + 1;
        $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;
        $newEmployee                         = new Employee;
        $newEmployee->employee_position_id   = 3;
        $newEmployee->code                   = $code;
        $newEmployee->name                   = 'Julian';
        $newEmployee->username               = 'rom1';
        $newEmployee->email                  = 'julian@gmail.com';
        $newEmployee->password               = Hash::make('12345678');
        $newEmployee->phone                  = $faker->phoneNumber();
        $newEmployee->save();
    }
}
