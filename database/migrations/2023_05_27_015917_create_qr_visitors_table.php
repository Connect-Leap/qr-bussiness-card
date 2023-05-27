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
        Schema::create('qr_visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_id')->constrained('qrs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('ip_address');
            $table->json('detail_visitor_json')->nullable();
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
        Schema::dropIfExists('qr_visitors');
    }
};
