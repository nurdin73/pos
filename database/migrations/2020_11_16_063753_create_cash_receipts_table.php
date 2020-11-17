<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('customers')->cascadeOnDelete();
            $table->bigInteger('jumlah');
            $table->bigInteger('dibayar')->default(0);
            $table->dateTime('tgl_kasbon');
            $table->dateTime('jatuh_tempo');
            $table->text('keterangan');
            $table->enum('status', ['belum lunas', 'lunas'])->default('belum lunas');
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
        Schema::dropIfExists('cash_receipts');
    }
}
