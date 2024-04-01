<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingScheduleLounge;
use App\Domain\Lounges\Models\Lounge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ScheduleLounge
 *
 * @property int $id Идентификатор расписания лаунджа
 * @property string $date Дата расписания лаунджа
 * @property string $time_from Время начала расписания лаунджа
 * @property string $time_to Время окончания расписания лаунджа
 * @property int $lounge_id Идентификатор лаунджа
 *
 * @property-read Lounge $lounge Лаунж
 * @property-read BookingScheduleLounge[] $bookingScheduleLounge Расписание лаунжей
 * @property-read Booking[] $booking Заявки
 */
class ScheduleLounge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'time_from',
        'time_to',
        'lounge_id',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->booking()->each(function ($booking) {
                $booking->delete();
            });
        });

        static::forceDeleting(function (self $model) {
            $model->booking()->each(function ($booking) {
                $booking->forceDelete();
            });
        });
    }

    public function lounge(): BelongsTo
    {
        return $this->belongsTo(Lounge::class)->withTrashed();
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_schedule_lounges')
            ->withPivot(['comment'])->withTrashed();
    }
}
