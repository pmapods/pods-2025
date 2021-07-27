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
            $table->integer('ticket_id')->nullable();
            $table->integer('ticket_vendor_id')->nullable();
            $table->integer('armada_ticket_id')->nullable();

            $table->string('vendor_name')->default('unset');
            $table->string('vendor_address')->default('unset');
            $table->string('send_name')->default('unset');
            $table->string('send_address')->default('unset');
            $table->integer('payment_days')->default(-1);
            $table->string('no_pr_sap')->default('unset');
            $table->string('no_po_sap')->default('unset');
            $table->string('supplier_pic_name')->default('unset')->nullable();
            $table->string('supplier_pic_position')->default('unset')->nullable();

            $table->boolean('has_ppn')->default(false);
            $table->tinyInteger('ppn_percentage')->nullable();
            
            $table->string('notes')->nullable();
            $table->integer('created_by')->default(-1);
            $table->string('internal_signed_filepath')->nullable();
            $table->string('external_signed_filepath')->nullable();
            $table->string('reject_notes')->nullable();
            $table->string('rejected_by')->nullable();
            $table->tinyInteger('status')->default(-1);
            // -1 po draft
            // 0 po diterbitkan
            // 1 purchasing sudah upload file tanda tangan basah
            // 2 supplier sudah upload file tanda tangan basah / menunggu approval tanda tangan
            // 3 selesai / tanda tangan lengkap

            $table->string('last_mail_send_to')->nullable();
            $table->string('po_upload_request_id')->nullable();
            $table->SoftDeletes();
            $table->timestamps();
        });

        Schema::create('po_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')->unsigned();
            $table->integer('ticket_item_id')->nullable();
            $table->string('item_name');
            $table->string('item_description');
            $table->string('uom')->default('AU');
            $table->integer('qty');
            $table->integer('item_price');
            $table->string('delivery_notes')->nullable();
            $table->foreign('po_id')->references('id')->on('po');
            $table->SoftDeletes();
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
            $table->uuid('id')->primary();
            $table->integer('po_id')->unsigned();
            $table->string('vendor_name');
            $table->string('vendor_pic');
            $table->string('filepath')->nullable();
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
        Schema::dropIfExists('po');
        Schema::dropIfExists('po_detail');
        Schema::dropIfExists('po_authorization');
        Schema::dropIfExists('po_upload_request');
    }
}
