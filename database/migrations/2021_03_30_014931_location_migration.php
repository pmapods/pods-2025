<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LocationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('salespoint', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->tinyInteger('region');
            //  0 MT CENTRAL 1
            //  1 SUMATERA 1
            //  2 SUMATERA 2
            //  3 SUMATERA 3
            //  4 SUMATERA 4
            //  5 BANTEN
            //  6 DKI
            //  7 JABAR 1
            //  8 JABAR 2
            //  9 R13 JABAR 3
            //  10 JATENG 1
            //  11 JATENG 2
            //  12 JATIM 1
            //  13 JATIM 2
            //  14 BALINUSRA
            //  15 KALIMANTAN
            //  16 SULAWESI
            $table->tinyInteger('status');
            // 0 depo
            // 1 cabang
            // 2 cellpoint
            // 3 subdist
            // 4 nasional
            $table->tinyInteger('trade_type');
            // 0 MT Modern Trade
            // 1 GT General Trade
            $table->boolean('isJawaSumatra');
            $table->string('grom')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
