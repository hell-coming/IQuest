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
        Schema::create('certificate_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название типа сертификата');
            $table->text('description')->comment('Описание типа сертификата');
            $table->decimal('price')->comment('Стоимость типа сертификата');
            $table->string('cover')->comment('Изображение типа сертификата');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_types');
    }
};
