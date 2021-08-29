<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BudgetUploadMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_upload', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salespoint_id')->unsigned();
            $table->integer('inventory_budget_id')->nullable();
            $table->string('code')->unique();
            $table->tinyInteger('status')->default(0);
            // -1 reject
            // 0 pending
            // 1 active
            $table->integer('created_by')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->integer('reject_notes')->nullable();
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('budget_upload_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_upload_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->tinyInteger('status')->default(0);
            // 0 pending
            // 1 approved
            // -1 reject
            $table->foreign('budget_upload_id')->references('id')->on('budget_upload');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('inventory_budget', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_upload_id')->unsigned();
            $table->string('code');
            $table->string('keterangan');
            $table->integer('qty');
            $table->double('value');
            $table->double('amount');
            $table->foreign('budget_upload_id')->references('id')->on('budget_upload');
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
