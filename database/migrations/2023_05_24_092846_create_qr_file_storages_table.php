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
        Schema::create('qr_file_storages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_id')->constrained('qrs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('file_storage_id')->constrained('file_storages')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('qr_file_storages');
    }
};
