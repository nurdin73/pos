<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pajak')->nullable();
            $table->bigInteger('persentase_pajak')->default(0);
            $table->enum('harga_barang', ['N', 'Y'])->default('N');
            $table->enum('biaya_pengiriman', ['N', 'Y'])->default('N');
            $table->enum('pajak_ditiadakan', ['N', 'Y'])->default('N');
            $table->bigInteger('biaya_layanan')->default(0);
            $table->enum('biaya_ditiadakan', ['N', 'Y'])->default('N');
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
        Schema::dropIfExists('taxes');
    }
}
