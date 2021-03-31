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
        //
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('phone');
            $table->string('position');
            $table->tinyInteger('status');
            // 0 Active
            // 1 Non Active
            $table->timestamps();
        });

        Schema::create('employee_access',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('location_access');
            $table->integer('menu_access');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employee');
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
