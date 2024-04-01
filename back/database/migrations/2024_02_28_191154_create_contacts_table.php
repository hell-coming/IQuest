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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('city_id')->constrained(table: 'cities')
                ->cascadeOnDelete();;
            $table->foreignId('contact_type_id')->constrained(table: 'contact_types')
                ->cascadeOnDelete();
            $table->string('value')->comment('Значение');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
