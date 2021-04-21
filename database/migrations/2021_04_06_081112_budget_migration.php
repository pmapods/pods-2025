<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BudgetMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_pricing_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('budget_pricing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('budget_pricing_category_id')->unsigned();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            // harga dalam jawa
            $table->double('injs_min_price')->nullable();
            $table->double('injs_max_price')->nullable();
            // harga luar jawa
            $table->double('outjs_min_price')->nullable();
            $table->double('outjs_max_price')->nullable();
            $table->foreign('budget_pricing_category_id')->references('id')->on('budget_pricing_category');
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
