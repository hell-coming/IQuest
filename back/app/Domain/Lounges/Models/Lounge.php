<?php

namespace App\Domain\Lounges\Models;

use App\Domain\Locations\Models\Filial;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Traits\HasCover;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lounge
 *
 * @property int $id Идентификатор лаунджа
 * @property string $name Название лаунджа
 * @property string $description Описание лаунджа
 * @property string $cover Обложка лаунджа
 * @property int $max_people Максимальное количество людей
 * @property int $price_per_half_hour Цена за половину часа
 * @property int $price_per_hour Цена за час
 * @property bool $is_active Статус отображения
 * @property int $filial_id Идентификатор филиала
 *
 * @property-read ScheduleLounge[] $scheduleLounges Расписание лаунжей
 * @property-read Filial $filial Филиал
 */
class Lounge extends Model
{
    use HasFactory, HasCover, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'cover',
        'max_people',
        'price_per_half_hour',
        'price_per_hour',
        'is_active',
        'filial_id',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->scheduleLounges()->each(function ($scheduleLounge) {
                if ($scheduleLounge->booking()->exists()) {
                    $scheduleLounge->delete();
                } else {
                    $scheduleLounge->forceDelete();
                }
            });
        });

        static::forceDeleting(function (self $model) {
            $model->scheduleLounges()->each(function ($scheduleLounge) {
                $scheduleLounge->forceDelete();
            });
        });
    }

    public function scheduleLounges(): HasMany
    {
        return $this->hasMany(ScheduleLounge::class)->withTrashed();
    }

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }
}
