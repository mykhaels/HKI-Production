<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('production_order_id');
            $table->bigInteger('product_id');
            $table->integer('qty');
            $table->bigInteger('uom_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_order_details');
    }
}
