<?php

use App\Domain\Bookings\Models\Booking;
use App\Domain\Schedules\Models\ScheduleLounge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_schedule_lounges', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('booking_id')->comment('Идентификатор бронирования')
                ->constrained(table: 'bookings');
            $table->foreignId('schedule_lounge_id')->comment('Идентификатор лаунжа')
                ->constrained(table: 'schedule_lounges');

            $table->string('comment')->nullable()->comment('Комментарий к заявке');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_schedule_lounges');
    }
};
