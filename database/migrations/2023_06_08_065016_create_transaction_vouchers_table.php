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
        Schema::create('transaction_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->double('discount');
            $table->integer('quota');
            $table->enum('status', ['valid', 'invalid']);
            $table->timestamp('expired_date');
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
        Schema::dropIfExists('transaction_vouchers');
    }
};
