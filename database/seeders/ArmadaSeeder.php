<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Armada;
use App\Models\ArmadaType;
use Faker\Factory as Faker;
use DB;

class ArmadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared("
            INSERT INTO armada_type(name,brand_name,alias,isNiaga) VALUES
            ('Grand Max Blind Van ','Daihatsu','BV',1),
            ('Grand Max Box','Daihatsu','GM Box',1),
            ('L300','Mitsubishi','L300',1),
            ('FE 71','Mitsubishi','Engkle',1),
            ('FE 71 LC','Mitsubishi','Engkle LC',1),
            ('FE 73','Mitsubishi','Double',1),
            ('FE 74','Mitsubishi','Double LC',1),
            ('GM Passanger ','Daihatsu',NULL,0),
            ('Xenia ','Daihatsu',NULL,0),
            ('Avanza E','Toyota',NULL,0),
            ('Avanza G','Toyota',NULL,0),
            ('Terios','Daihatsu',NULL,0),
            ('Rush','Toyota',NULL,0),
            ('Innova','Toyota',NULL,0),
            ('Fortuner','Toyota',NULL,0);        
        ");
        // $faker = Faker::create('id_ID');
        // for ($i=0; $i < 5; $i++) { 
        //     $armadatype = new ArmadaType;
        //     $armadatype->name = $faker->unique()->word;
        //     $armadatype->brand_name = ($i%2==1) ? 'Daihatsu' : 'Toyota'; 
        //     $armadatype->alias = $armadatype->brand_name.$i;
        //     $armadatype->isNiaga = false;
        //     $armadatype->save();
        //     $armada = new Armada;
        //     $armada->salespoint_id = 1;
        //     $armada->armada_type_id = $armadatype->id;
        //     $armada->plate = strtoupper($faker->bothify('? #### ???'));
        //     $armada->status = $i%2;
        //     if($armada->status == 1){
        //         $armada->booked_by = $faker->name;
        //     }
        //     $armada->save();
        // }
        // for ($i=0; $i < 5; $i++) { 
        //     $armadatype = new ArmadaType;
        //     $armadatype->name = $faker->unique()->word;
        //     $armadatype->brand_name = $faker->unique()->word; 
        //     $armadatype->alias = ($i%2==1) ? 'Daihatsu' : 'Mitsubishi';
        //     $armadatype->isNiaga = true;
        //     $armadatype->save();
        //     $armada = new Armada;
        //     $armada->salespoint_id = 1;
        //     $armada->armada_type_id = $armadatype->id;
        //     $armada->plate = strtoupper($faker->bothify('? #### ???'));
        //     $armada->status = $i%2;
        //     $armada->save();
        // }
    }
    
}
