<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();
            $table->integer('file_size')->comment('Ukuran File');
            $table->string('file_driver')->comment('Driver File');
            $table->string('file_extension')->comment('Ekstensi File');
            $table->string('file_original_name')->comment('Nama Original Dari File');
            $table->string('file_name')->comment('Nama File yang sudah Di Encrypt');
            $table->string('file_path')->comment('Direktori File');
            $table->string('file_type')->comment('Tipe File Contoh image/png, image/jpeg, dll');
            $table->text('file_url')->comment('URL Dari Suatu File');
            $table->boolean('is_used')->default(false);
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
        Schema::dropIfExists('file_storages');
    }
};
