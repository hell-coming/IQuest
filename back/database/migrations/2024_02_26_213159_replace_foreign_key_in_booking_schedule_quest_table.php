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
        Schema::table('booking_schedule_quests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('schedule_quest_id');

            $table->foreignId('timeslot_id')->constrained(table: 'timeslots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_schedule_quests', function (Blueprint $table) {
            $table->foreignId('schedule_quest_id')->constrained(table: 'schedule_quests');

            $table->dropConstrainedForeignId('timeslot_id');
        });
    }
};
