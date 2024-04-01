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
        Schema::create('holiday_packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('holiday_id')->comment('Праздник')
                ->constrained(table: 'holidays');
            $table->foreignId('package_id')->comment('Пакет')
                ->constrained(table: 'packages');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_packages');
    }
};
