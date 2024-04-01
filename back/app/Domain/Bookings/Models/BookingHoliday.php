<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Holidays\Models\HolidayPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BookingHoliday
 *
 * @property int $id Идентификатор заявки на праздник
 * @property int $booking_id Идентификатор бронирования
 * @property int $holiday_package_id Идентификатор пакета праздника
 * @property string|null $comment Комментарий
 *
 * @property-read Booking $booking Бронирование
 * @property-read HolidayPackage $holidayPackage Пакет праздника
 */
class BookingHoliday extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'holiday_package_id',
        'comment',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            resolve(SendMessageBookingAction::class)->execute($model->booking);
        });

        static::deleted(function (self $model) {
            $model->booking()->delete();
        });

        static::forceDeleted(function (self $model) {
            $model->booking()->forceDelete();
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withTrashed();
    }

    public function holidayPackage(): BelongsTo
    {
        return $this->belongsTo(HolidayPackage::class)->withTrashed();
    }
}
