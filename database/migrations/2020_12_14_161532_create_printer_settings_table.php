<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrinterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printer_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('os', ['windows', 'linux', 'mac'])->default('windows');
            $table->enum('koneksi', ['usb', 'ethernet', 'bluetooth'])->default('usb');
            $table->string('name_printer');
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
        Schema::dropIfExists('printer_settings');
    }
}
