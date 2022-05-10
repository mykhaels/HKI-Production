<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cards', function (Blueprint $table) {
            $table->id();
            $table->char('code');
            $table->date('transaction_date');
            $table->char('product_type');
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
        Schema::dropIfExists('stock_cards');
    }
}
