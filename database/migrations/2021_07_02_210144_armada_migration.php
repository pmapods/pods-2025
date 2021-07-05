<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArmadaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('armada', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salespoint_id')->unsigned();
            $table->string('name');
            $table->string('plate');
            $table->tinyInteger('status')->default('0');
            // 0 available
            // 1 booked
            $table->string('booked_by')->nullable();
            $table->boolean('isNiaga');
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->softDeletes();
            $table->timestamps();
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
