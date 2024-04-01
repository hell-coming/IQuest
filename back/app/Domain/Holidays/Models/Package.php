<?php

namespace App\Domain\Holidays\Models;

use App\Domain\Bookings\Models\BookingHoliday;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Package
 *
 * @property int $id Идентификатор пакета
 * @property string $name Название пакета
 * @property string $description Описание пакета
 * @property float $price Цена пакета
 * @property bool $is_active Статус отображения
 * @property int $sequence_number Порядковый номер пакета
 *
 * @property-read Holiday[] $holidays
 * @property-read HolidayPackage[] $holidayPackages
 */
class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',
        'sequence_number',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->holidayPackages()->each(function (HolidayPackage $holidayPackage) {
                $holidayPackage->bookingHolidays()->each(function (BookingHoliday $bookingHoliday) {
                    $bookingHoliday->delete();
                });
                $holidayPackage->delete();
            });
        });

        static::forceDeleting(function (self $model) {
            $model->holidayPackages()->each(function (HolidayPackage $holidayPackage) {
                $holidayPackage->bookingHolidays()->each(function (BookingHoliday $bookingHoliday) {
                    $bookingHoliday->forceDelete();
                });
                $holidayPackage->forceDelete();
            });
        });

        static::restoring(function (self $model) {
            $model->holidayPackages()->restore();
        });
    }

    public function holidays(): BelongsToMany
    {
        return $this->belongsToMany(Holiday::class, 'holiday_packages');
    }

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class)->withTrashed();
    }
}
