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
        Schema::create('user_nationalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('country_name');
            $table->string('country_code')->comment('Ex: INA, USA, JP, etc');
            $table->string('country_phone_code')->comment('EX: +62, etc');
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
        Schema::dropIfExists('user_nationalities');
    }
};
