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
        Schema::create('booking_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('booking_id')->comment('Идентификатор бронирования')
                ->constrained(table: 'bookings');
            $table->foreignId('certificate_type_id')->comment('Идентификатор типа сертификата')
                ->constrained(table: 'certificate_types');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_certificates');
    }
};
