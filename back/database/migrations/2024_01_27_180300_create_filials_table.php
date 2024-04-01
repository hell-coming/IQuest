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
        Schema::create('filials', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('address')->comment('Адрес филиала');
            $table->string('yandex_mark')->nullable()->comment('Яндекс метка');
            $table->foreignId('city_id')->comment('Ключ города')->constrained(table: 'cities');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filials');
    }
};
