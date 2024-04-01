<?php

namespace App\Domain\Holidays\Models;

use App\Domain\Bookings\Models\BookingHoliday;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HolidayPackage
 *
 * @property int $id Идентификатор пакета праздника
 * @property int $holiday_id Идентификатор праздника
 * @property int $package_id Идентификатор пакета
 *
 * @property-read Holiday $holiday Праздник
 * @property-read Package $package Пакет
 */
class HolidayPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'holiday_id',
        'package_id',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->bookingHolidays()->each(function (BookingHoliday $bookingHoliday) {
                $bookingHoliday->delete();
            });
        });

        static::forceDeleted(function (self $model) {
            $model->bookingHolidays()->each(function (BookingHoliday $bookingHoliday) {
                $bookingHoliday->forceDelete();
            });
        });
    }

    public function holiday(): BelongsTo
    {
        return $this->belongsTo(Holiday::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function bookingHolidays(): HasMany
    {
        return $this->hasMany(BookingHoliday::class)->withTrashed();
    }
}
