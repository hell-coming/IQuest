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
        Schema::create('filial_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('filial_id')->comment('Филиал')->constrained(table: 'filials')
                ->cascadeOnDelete();
            $table->foreignId('user_id')->comment('Пользователь')->constrained(table: 'users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filial_users');
    }
};
