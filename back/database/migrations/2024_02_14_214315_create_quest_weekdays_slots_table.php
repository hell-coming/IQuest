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
        Schema::create('quest_weekdays_slots', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('quest_id')->comment('Квест')->constrained(table: 'quests');
            $table->time('time')->comment('Время');
            $table->decimal('price')->comment('Цена');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quest_weekdays_slots');
    }
};
