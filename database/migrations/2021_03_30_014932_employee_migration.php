<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //daftar karyawan
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('position');
            $table->tinyInteger('status');
            // 0 Active
            // 1 Non Active
            $table->timestamps();
        });

        // daftar akses tiap karyawan bisa di salespoint mana  aja
        Schema::create('employee_location_access',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('salespoint_id')->unsigned();
            $table->integer('location_access');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
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
