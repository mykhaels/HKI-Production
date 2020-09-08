<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('delivery_request_id');
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
        Schema::dropIfExists('delivery_request_details');
    }
}
