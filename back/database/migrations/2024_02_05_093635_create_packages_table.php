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
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название пакета');
            $table->text('description')->comment('Описание пакета');
            $table->decimal('price')->comment('Цена пакета');
            $table->boolean('is_active')->comment('Активность пакетa');
            $table->unsignedInteger('sequence_number')->comment('Порядковый номер пакета');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
