<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Armada;
use Faker\Factory as Faker;

class ArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i=0; $i < 10; $i++) { 
            $armada = new Armada;
            $armada->salespoint_id = 1;
            $armada->name = $faker->unique()->word();
            $armada->plate = $faker->bothify('? #### ???');
            $armada->status = $i%2;
            if($armada->status == 1){
                $armada->booked_by = $faker->name;
            }
            $armada->isNiaga = false;
            $armada->save();
        }
        for ($i=0; $i < 10; $i++) { 
            $armada = new Armada;
            $armada->salespoint_id = 1;
            $armada->name = $faker->unique()->word();
            $armada->plate = $faker->bothify('? #### ???');
            $armada->status = $i%2;
            if($armada->status == 1){
                $armada->booked_by = $faker->name;
            }
            $armada->isNiaga = true;
            $armada->save();
        }
    }
    
}
