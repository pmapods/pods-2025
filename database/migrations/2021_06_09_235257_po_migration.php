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
