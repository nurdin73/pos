<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->bigInteger('qyt')->default(1);
            $table->bigInteger('harga_product')->default(0);
            $table->boolean('eceran')->default(0);
            $table->bigInteger('diskon_product')->default(0);
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
        Schema::dropIfExists('carts');
    }
}
