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
        Schema::create('schedule_lounges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date')->comment('Дата');
            $table->time('time_from')->comment('Время начала');
            $table->time('time_to')->comment('Время конца');
            $table->foreignId('lounge_id')->comment('Лаунж')->constrained(table: 'lounges');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_lounges');
    }
};
