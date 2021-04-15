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
        $data =[
            [
                "code" => "1001000",
                "name" => "DAAN MOGOT MT",
                "region" => 0,
                "status" => 1,
                "trade_type" => 1,
                "isJawaSumatra" => 1,
                "grom" => "Hafid Fauzi",
            ],
            [
                "code" => "1000913",
                "name" => "JABODETABEK MT",
                "region" => 0,
                "status" => 0,
                "trade_type" => 1,
                "isJawaSumatra" => 1,
                "grom" => "Hafid Fauzi",
            ],
            [
                "code" => "1000570",
                "name" => "MEDAN TIMUR",
                "region" => 1,
                "status" => 1,
                "trade_type" => 0,
                "isJawaSumatra" => 1,
                "grom" => "Rudy Maryadin",
            ],
            [
                "code" => "1000810",
                "name" => "BINJAI",
                "region" => 1,
                "status" => 0,
                "trade_type" => 0,
                "isJawaSumatra" => 1,
                "grom" => "Rudy Maryadin",
            ],
        ];
        foreach ($data as $salespoint){
            $newsalespoint                 = new SalesPoint;
            $newsalespoint->code           = $salespoint['code'];
            $newsalespoint->name           = $salespoint['name'];
            $newsalespoint->region         = $salespoint['region'];
            $newsalespoint->status         = $salespoint['status'];
            $newsalespoint->trade_type     = $salespoint['trade_type'];
            $newsalespoint->isJawaSumatra  = $salespoint['isJawaSumatra'];
            $newsalespoint->grom           = $salespoint['grom'];
            $newsalespoint->save();
        }
    }
}
