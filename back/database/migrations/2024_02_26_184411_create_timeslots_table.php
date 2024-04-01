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
        Schema::create('timeslots', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->time('time')->comment('Время');
            $table->decimal('price')->comment('Цена');
            $table->boolean('is_active')->comment('Статус активности');

            $table->foreignId('schedule_quest_id')->comment('Расписание')->constrained(table: 'schedule_quests');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslots');
    }
};
