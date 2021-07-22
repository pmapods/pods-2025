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
            $table->integer('armada_type_id')->unsigned();
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
            // 1 Pending Authorization
            // 2 Finish Authorization
            $table->integer('created_by')->nullable();
            $table->integer('terminated_by')->nullable();
            $table->string('termination_reason')->nullable();
            $table->date('requirement_date');
            $table->date('finished_date')->nullable();
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->foreign('armada_type_id')->references('id')->on('armada_type');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('armada_ticket_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('armada_ticket_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->tinyInteger('status')->default(0);
            // 0 pending
            // 1 approved
            // -1 reject
            $table->foreign('armada_ticket_id')->references('id')->on('armada_ticket');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->timestamps();
        });

        Schema::create('facility_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('armada_ticket_id')->unsigned();
            $table->integer('salespoint_id')->unsigned();
            $table->string('code');
            $table->string('nama');
            $table->string('divisi');
            $table->string('phone');
            $table->string('jabatan');
            $table->date('tanggal_mulai_kerja');
            $table->string('golongan');
            $table->enum('status_karyawan', ['percobaan', 'tetap']);
            $table->json('facilitylist')->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('terminated_by')->nullable();
            $table->string('termination_reason')->nullable();
            $table->tinyInteger('status')->default(0);
            // 0 new / waiting for approval
            // -1 terminated
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->foreign('armada_ticket_id')->references('id')->on('armada_ticket');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('facility_form_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_form_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->tinyInteger('status')->default(0);
            // 0 pending
            // 1 approved
            // -1 reject
            $table->foreign('facility_form_id')->references('id')->on('facility_form');
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
    }
}
