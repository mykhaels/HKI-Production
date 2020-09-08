<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNoteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_note_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('delivery_note_id');
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
        Schema::dropIfExists('delivery_note_details');
    }
}
