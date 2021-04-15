<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuthorizationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salespoint_id')->unsigned();
            $table->tinyInteger('form_type')->default(0);
            // 0 form pengadaan
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->timestamps();
        });

        Schema::create('authorization_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('authorization_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('sign_as');
            $table->integer('level');
            $table->foreign('authorization_id')->references('id')->on('authorization');
            $table->foreign('employee_id')->references('id')->on('employee');
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
