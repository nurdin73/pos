<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('suplier_id')->nullable();
            $table->bigInteger('cabang_id')->nullable();
            $table->string('nama_barang');
            $table->enum('type_barang', ['baru', 'bekas']);
            $table->string('kode_barang');
            $table->bigInteger('harga_jual')->default(0);
            $table->bigInteger('selled')->default(0);
            $table->foreignId('kategori_id')->constrained('categories')->cascadeOnDelete();
            $table->bigInteger('berat')->nullable();
            $table->enum('satuan', ['gram', 'pcs'])->nullable();
            $table->integer('diskon')->nullable();
            $table->string('rak')->nullable();
            $table->longText('keterangan')->nullable();
            $table->bigInteger('point')->default(0);
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
        Schema::dropIfExists('products');
    }
}
