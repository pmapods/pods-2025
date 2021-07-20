<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArmadaTicketingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armada_ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('salespoint_id')->unsigned();
            $table->integer('armada_type_id')->nullable();
            $table->integer('armada_id')->nullable();
            $table->boolean('isNiaga');
            $table->tinyInteger('ticketing_type');
            // 0 Pengadaan Baru                
            // 1 Perpanjangan/Replace/Renewal/Stop Sewa
            // 2 Mutasi
            // 3 COP
            $table->tinyInteger('status')->default(0);
            // -1 Terminated
            // 0 New
            // 1
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('terminated_by')->unsigned()->nullable();
            $table->string('termination_reason')->nullable();
            $table->date('requirement_date');
            $table->date('finished_date')->nullable();
            $table->foreign('created_by')->references('id')->on('employee');
            $table->foreign('terminated_by')->references('id')->on('employee');
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
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
