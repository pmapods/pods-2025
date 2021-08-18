<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeder_array = [
            IndoRegionSeeder::class,
            SalespointSeeder::class,
            SuperAdminSeeder::class,
            BudgetCategorySeeder::class,
            BudgetSeeder::class,
            FileCompletementSeeder::class,
            VendorSeeder::class,
            ArmadaSeeder::class,
        ];
        $dev_array = [
            EmployeeSeeder::class,
            AuthorizationSeeder::class,
        ];
        if(App::environment('local')) {
            $seeder_array = array_merge($seeder_array,$dev_array);
        }
        $this->call($seeder_array);
    }
}
