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
        Schema::create('booking_holidays', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('booking_id')->comment('Бронирование')
                ->constrained(table: 'bookings');
            $table->foreignId('holiday_package_id')->comment('Тип праздника и пакет')
                ->constrained(table: 'holiday_packages');

            $table->string('comment')->nullable()->comment('Комментарий');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_holidays');
    }
};
