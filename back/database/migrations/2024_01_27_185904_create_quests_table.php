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
        Schema::create('quests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('Название квеста');
            $table->string('slug')->comment('Сокращенное имя квеста');
            $table->text('description')->comment('Описание квеста');
            $table->text('short_description')->comment('Краткое описание квеста');
            $table->string('cover')->comment('Обложка квеста');
            $table->integer('min_people')->comment('Минимальное кол-во людей');
            $table->integer('max_people')->comment('Максимальное кол-во людей');
            $table->integer('duration')->comment('Продолжительность квеста');
            $table->integer('level')->comment('Уровень сложности');
            $table->boolean('is_active')->comment('Статус активности отображения на сайте');
            $table->integer('sequence_number')->comment('Порядковый номер квеста');

            $table->foreignId('filial_id')->comment('Адрес квеста')->constrained(table: 'filials');
            $table->foreignId('type_id')->comment('Тип квеста')->constrained(table: 'types');
            $table->foreignId('genre_id')->comment('Жанр квеста')->constrained(table: 'genres');
            $table->foreignId('age_limit_id')->comment('Возрастное ограничение квеста')->constrained(table: 'age_limits');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
