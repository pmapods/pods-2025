<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_vendor_id')->unsigned();
            $table->string('vendor_address');
            $table->string('send_address');
            $table->integer('payment_days');
            $table->string('no_pr_sap');
            $table->string('no_po_sap');
            $table->string('supplier_pic_name');
            $table->string('supplier_pic_position');
            $table->boolean('has_ppn')->default(false);
            $table->tinyInteger('ppn_percentage')->nullable();
            $table->string('notes')->nullable();
            $table->integer('created_by');
            $table->string('internal_signed_filepath')->nullable();
            $table->string('external_signed_filepath')->nullable();
            $table->string('reject_notes')->nullable();
            $table->string('rejected_by')->nullable();
            $table->tinyInteger('status')->default(0);
            // 0 po diterbitkan
            // 1 purchasing sudah upload file tanda tangan basah
            // 2 supplier sudah upload file tanda tangan basah / menunggu approval tanda tangan
            // 3 selesai / tanda tangan lengkap
            $table->foreign('ticket_vendor_id')->references('id')->on('ticket_vendor');
            $table->timestamps();
        });

        Schema::create('po_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->foreign('po_id')->references('id')->on('po');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->SoftDeletes();
            $table->timestamps();
        });

        Schema::create('po_upload_request', function (Blueprint $table){
            $table->uuid('id');
            $table->integer('po_id')->unsigned();
            $table->string('vendor_name');
            $table->string('vendor_pic');
            $table->string('filepath');
            $table->tinyInteger('status')->default(0);
            // 0 new
            // 1 uploaded
            // 2 Approved
            // -1 Rejected
            $table->boolean('isExpired')->default(false);
            $table->boolean('isOpened')->default(false);
            $table->string('notes')->nullable();
            $table->foreign('po_id')->references('id')->on('po');
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
