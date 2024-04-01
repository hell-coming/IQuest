<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Schedules\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BookingScheduleQuest
 *
 * @property int $id Идентификатор бронирования квеста
 * @property int $booking_id Идентификатор бронирования
 * @property int $schedule_quest_id Идентификатор расписания квеста
 * @property int $count_participants Количество участников
 * @property float $final_price Итоговая цена
 * @property string|null $comment Комментарий
 *
 * @property-read Booking $booking Бронирование
 * @property-read Timeslot $timeslot Расписание
 */
class BookingScheduleQuest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'timeslot_id',
        'count_participants',
        'final_price',
        'comment',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            $model->timeslot()->update(['is_active' => false]);
            resolve(SendMessageBookingAction::class)->execute($model->booking);
        });

        static::deleting(function (self $model) {
            $model->booking()->delete();
        });

        static::forceDeleting(function (self $model) {
            $model->booking()->forceDelete();
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withTrashed();
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class)->withTrashed();
    }
}
