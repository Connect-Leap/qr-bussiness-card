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
        Schema::create('qrs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('qr_contact_type_id')->constrained('qr_contact_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('offices')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->longText('redirect_link')->nullable();
            $table->longText('vcard_string')->nullable();
            $table->integer('usage_limit');
            $table->enum('status', ['valid', 'invalid']);
            $table->foreignId('created_by')->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('created_for_user_office')->nullable()->constrained('offices')
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
        Schema::dropIfExists('qrs');
    }
};
