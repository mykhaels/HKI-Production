<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_payments', function (Blueprint $table) {
            $table->id();
            $table->char('code');
            $table->date('transaction_date');
            $table->integer('purchase_order_id');
            $table->integer('supplier_id');
            $table->decimal('dp',20,2);
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
        Schema::dropIfExists('initial_payments');
    }
}
