<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Schedules\Models\ScheduleLounge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BookingScheduleLounge
 *
 * @property int $id Идентификатор бронирования лаунджа
 * @property int $booking_id Идентификатор бронирования
 * @property int $schedule_lounge_id Идентификатор расписания лаунджа
 * @property string|null $comment Комментарий
 *
 * @property-read Booking $booking Бронирование
 * @property-read ScheduleLounge $scheduleLounge Расписание
 */
class BookingScheduleLounge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'schedule_lounge_id',
        'comment',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withTrashed();
    }

    public function scheduleLounge(): BelongsTo
    {
        return $this->belongsTo(ScheduleLounge::class)->withTrashed();
    }
}
