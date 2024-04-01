<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Имя');
            $table->string('phone')->comment('Телефон');
            $table->string('type')->comment('Тип заявки');
            $table->string('status')->comment('Статус заявки');

            $table->foreignId('city_id')->comment('Город')->constrained(table: 'cities');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
