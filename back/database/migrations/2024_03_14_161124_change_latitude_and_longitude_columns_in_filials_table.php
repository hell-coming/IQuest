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
        Schema::table('filials', function (Blueprint $table) {
            $table->decimal('latitude', 8, 6)->change();
            $table->decimal('longitude', 9, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('filials', function (Blueprint $table) {
            $table->decimal('latitude', 10, 6)->change();
            $table->decimal('longitude', 10, 6)->change();
        });
    }
};
