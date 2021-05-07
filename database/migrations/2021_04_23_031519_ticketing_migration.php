<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            // PCD-YYMMDD-0001
            $table->date('requirement_date')->nullable();
            $table->integer('salespoint_id')->unsigned();
            $table->integer('authorization_id')->unsigned()->nullable();
            $table->tinyInteger('item_type')->nullable();
            // 0 barang
            // 1 Jasa
            $table->tinyInteger('request_type')->nullable();
            // 0 Baru
            // 1 Replace Existing
            // 2 Repeat Order
            $table->tinyInteger('budget_type')->nullable();
            // 0 Budget
            // 1 NonBudget
            $table->text('reason')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('terminated_by')->nullable();
            $table->string('termination_reason')->nullable();
            $table->tinyInteger('status')->default(0);
            // 0 draft
            // 1 waiting for authorization / authorization started
            // 2 finished authorization / waiting for bidding
            // 3 terminated / cancelled
            $table->string('ba_vendor_filename')->nullable();
            $table->string('ba_vendor_filepath')->nullable();
            $table->foreign('salespoint_id')->references('id')->on('salespoint');
            $table->foreign('authorization_id')->references('id')->on('authorization');
            $table->foreign('created_by')->references('id')->on('employee');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ticket_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned();
            $table->integer('budget_pricing_id')->nullable();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->date('expired_date')->nullable();
            $table->double('price');
            $table->integer('count');
            $table->foreign('ticket_id')->references('id')->on('ticket');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ticket_item_attachment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_item_id')->unsigned();
            $table->string('name');
            $table->string('path');
            $table->foreign('ticket_item_id')->references('id')->on('ticket_item');
            $table->timestamps();
        });

        Schema::create('ticket_vendor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned();
            $table->integer('vendor_id')->nullable();
            $table->string('name');
            $table->string('salesperson');
            $table->string('phone');
            $table->tinyInteger('type');
            // 0 Registered Vendor
            // 1 One Time Vendor
            $table->foreign('ticket_id')->references('id')->on('ticket');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ticket_additional_attachment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('ticket');
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('ticket_authorization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('employee_name');
            $table->string('as');
            $table->string('employee_position');
            $table->tinyInteger('level');
            $table->tinyInteger('status')->default(0);
            // 0 pending
            // 1 approved
            // 2 terminate
            $table->foreign('ticket_id')->references('id')->on('ticket');
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
