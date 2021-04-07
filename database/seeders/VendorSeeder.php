<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Regency;
use Faker\Factory as Faker;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i=0; $i<100; $i++){
            $newVendor                = new Vendor;
            $newVendor->code          = 'V-'.$i;
            $newVendor->name          = $faker->company();
            $newVendor->address       = $faker->address();
            $newVendor->city_id       = Regency::inRandomOrder()->first()->id;
            $newVendor->salesperson   = $faker->firstName();
            $newVendor->phone         = $faker->phoneNumber();
            $newVendor->save();
        }
    }
}
