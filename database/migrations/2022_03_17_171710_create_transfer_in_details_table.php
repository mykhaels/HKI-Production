<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_in_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transfer_in_id');
            $table->bigInteger('product_id');
            $table->integer('qty');
            $table->bigInteger('uom_id');
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
        Schema::dropIfExists('transfer_in_details');
    }
}
