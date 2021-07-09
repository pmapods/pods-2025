<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Armada;
use App\Models\ArmadaType;
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
        for ($i=0; $i < 5; $i++) { 
            $armadatype = new ArmadaType;
            $armadatype->name = $faker->unique()->word;
            $armadatype->brand_name = $faker->unique()->word; 
            $armadatype->alias = '"'.$armadatype->brand_name.'"';
            $armadatype->isNiaga = false;
            $armadatype->save();
            $armada = new Armada;
            $armada->salespoint_id = 1;
            $armada->armada_type_id = $armadatype->id;
            $armada->plate = $faker->bothify('? #### ???');
            $armada->status = $i%2;
            if($armada->status == 1){
                $armada->booked_by = $faker->name;
            }
            $armada->save();
        }
        for ($i=0; $i < 5; $i++) { 
            $armadatype = new ArmadaType;
            $armadatype->name = $faker->unique()->word;
            $armadatype->brand_name = $faker->unique()->word; 
            $armadatype->alias = '"'.$armadatype->brand_name.'"';
            $armadatype->isNiaga = true;
            $armadatype->save();
            $armada = new Armada;
            $armada->salespoint_id = 1;
            $armada->armada_type_id = $armadatype->id;
            $armada->plate = $faker->bothify('? #### ???');
            $armada->status = $i%2;
            $armada->save();
        }
    }
    
}
