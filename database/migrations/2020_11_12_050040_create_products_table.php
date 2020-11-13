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
            $table->string('nama_barang');
            $table->enum('type_barang', ['baru', 'bekas']);
            $table->string('kode_barang');
            $table->bigInteger('harga_dasar')->default(0);
            $table->bigInteger('harga_jual')->default(0);
            $table->bigInteger('stok')->default(0);
            $table->foreignId('kategori_id')->constrained('categories')->cascadeOnDelete();
            $table->float('berat')->default(0.5)->nullable();
            $table->enum('satuan', ['gram', 'pcs'])->nullable();
            $table->integer('diskon')->nullable();
            $table->string('rak')->nullable();
            $table->longText('keterangan')->nullable();
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
