<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->foreignId('createdBy')->constrained('users')->cascadeOnDelete();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('diskon_transaksi')->default(0);
            $table->bigInteger('total');
            $table->longText('keterangan')->nullable();
            $table->dateTime('tgl_transaksi');
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
        Schema::dropIfExists('transactions');
    }
}
