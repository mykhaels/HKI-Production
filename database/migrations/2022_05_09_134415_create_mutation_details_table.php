<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutation_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mutation_id');
            $table->bigInteger('product_id');
            $table->bigInteger('type');
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
        Schema::dropIfExists('mutation_details');
    }
}
