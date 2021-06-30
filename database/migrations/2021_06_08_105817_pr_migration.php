<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->integer('created_by');
            $table->tinyInteger('status')->default(0);
            // 0 Menunggu proses otorisasi
            // 1 proses otorisasi selesai
            // 2 nomor asset sudah di update / ready for po
            // -1 rejected
            $table->integer('assetnumber_by')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->string('reject_reason')->nullable();
            $table->foreign('ticket_id')->references('id')->on('ticket');
            $table->SoftDeletes();
            $table->timestamps();
        });

        Schema::create('pr_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pr_id')->unsigned();
            $table->integer('ticket_item_id')->unsigned();
            $table->integer('qty');
            $table->double('price');
            $table->string('uom')->nullable();
            $table->date('setup_date')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('isAsset')->nullable();
            
            $table->string('asset_number')->nullable();
            $table->uuid('asset_number_token')->unique();
            $table->string('asset_number_by')->nullable();
            $table->datetime('asset_number_at')->nullable();

            $table->foreign('pr_id')->references('id')->on('pr');
            $table->foreign('ticket_item_id')->references('id')->on('ticket_item');
            $table->SoftDeletes();
            $table->timestamps();
        });

        schema::create('pr_log', function (Blueprint $table){
            $table->increments('id');
            $table->string('message');
            $table->integer('pr_id')->unsigned();
            $table->foreign('pr_id')->references('id')->on('pr');
            $table->timestamps();
        });

        Schema::create('pr_authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pr_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->tinyInteger('status')->default(0);
            // -1 terminate
            // 0 pending
            // 1 approved
            $table->foreign('pr_id')->references('id')->on('pr');
            $table->foreign('employee_id')->references('id')->on('employee');
            $table->SoftDeletes();
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
