<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ScheduleQuest
 *
 * @property int $id Идентификатор расписания квеста
 * @property string $date Дата расписания квеста
 * @property int $quest_id Идентификатор квеста
 *
 * @property Quest $quest Квест
 * @property HasMany $timeslots Временные слоты
 * @property Booking $booking Бронирование
 */
class ScheduleQuest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'quest_id',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->timeslots()->each(function (Timeslot $timeslot) {
                if ($timeslot->booking()->doesntExist()) {
                    $timeslot->forceDelete();
                } else {
                    $timeslot->delete();
                }
            });
        });

        static::forceDeleting(function (self $model) {
            $model->timeslots()->each(function (Timeslot $timeslot) {
                $timeslot->forceDelete();
            });
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class)->withTrashed();
    }

    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class)->withTrashed();
    }
}
