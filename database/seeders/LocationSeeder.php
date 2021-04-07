<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesPoint;
use Faker\Factory as Faker;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run()
    {
        $faker = Faker::create('id_ID');
        // 17 region
        $count=0;
        for($i=0; $i<17; $i++){
            // sample 10 location each region
            for($j=0; $j<5; $j++){
                $salespoint = new SalesPoint;
                $salespoint->code           = 'samplecode-'.$count;
                $salespoint->name           = $faker->city();
                $salespoint->region         = $i;
                $salespoint->status         = array_rand ( [0,1,2,3] );
                $salespoint->trade_type     = array_rand([0, 1]);
                $salespoint->isJawaSumatra  = array_rand([0, 1]);
                $salespoint->grom           = $faker->firstName();
                $salespoint->save();
                $count++;
            }
        }
    }
}
