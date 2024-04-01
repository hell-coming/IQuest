<?php

namespace App\Domain\Quests\Models;

use App\Domain\Locations\Models\Filial;
use App\Domain\Quests\Enums\LevelEnum;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Traits\HasCover;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Quest
 *
 * @property int $id - Идентификатор квеста
 * @property string $name - Название квеста
 * @property string $slug - Сокращенное название квеста
 * @property string $short_description - Краткое описание квеста
 * @property string $description - Описание квеста
 * @property string $cover - Обложка квеста
 * @property int $min_people - Минимальное количество участников
 * @property int $max_people - Максимальное количество участников
 * @property int $duration - Продолжительность
 * @property LevelEnum $level - Уровень сложности
 * @property bool $is_active - Активность на клиентской части
 * @property int $sequence_number - Порядковый номер
 * @property int $filial_id - Идентификатор филиала
 * @property int $type_id - Идентификатор типа
 * @property int $genre_id - Идентификатор жанра
 * @property int $age_limit_id - Идентификатор возрастного ограничения
 *
 * @property-read Filial $filial
 * @property-read Type $type
 * @property-read Genre $genre
 * @property-read AgeLimit $age_limit
 * @property-read QuestImage[] $images
 */
class Quest extends Model
{
    use HasFactory, HasCover, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'cover',
        'min_people',
        'max_people',
        'duration',
        'level',
        'is_active',
        'sequence_number',
        'filial_id',
        'type_id',
        'genre_id',
        'age_limit_id',
    ];

    protected $casts = [
        'level' => LevelEnum::class,
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->questWeekdaysSlots()->delete();
            $model->questWeekendSlots()->delete();

            $model->scheduleQuests()->each(function (ScheduleQuest $scheduleQuest) {
                $scheduleQuest->delete();
            });
        });

        static::forceDeleting(function (self $model) {
            $model->scheduleQuests()->each(function (ScheduleQuest $scheduleQuest) {
                $scheduleQuest->forceDelete();
            });
        });
    }

    public function scheduleQuests(): HasMany
    {
        return $this->hasMany(ScheduleQuest::class)->withTrashed();
    }

    public function questWeekdaysSlots(): HasMany
    {
        return $this->hasMany(QuestWeekdaysSlot::class);
    }

    public function questWeekendSlots(): HasMany
    {
        return $this->hasMany(QuestWeekendSlot::class);
    }

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function age_limit(): BelongsTo
    {
        return $this->belongsTo(AgeLimit::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(QuestImage::class);
    }
}
