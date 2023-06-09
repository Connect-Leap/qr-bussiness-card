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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->nullable();
            $table->unsignedBigInteger('transaction_voucher_id');
            $table->double('price');
            $table->double('total_price');
            $table->timestamp('transaction_time');
            $table->string('payment_type');
            $table->text('payment_pdf_url');
            $table->timestamp('expired_date_until')->nullable();
            $table->text('snap_token');
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
};
