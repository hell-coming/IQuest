<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Locations\Models\City;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Schedules\Models\Timeslot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking
 *
 * @property int $id Идентификатор бронирования
 * @property string $name Имя клиента
 * @property string $phone Номер клиента
 * @property BookingType $type Тип
 * @property BookingStatus $status Статус
 * @property int $city_id Идентификатор Города
 *
 * @property-read  City $city
 * @property-read  BookingScheduleQuest $bookingScheduleQuest
 * @property-read  BookingScheduleLounge $bookingScheduleLounge
 * @property-read  ScheduleQuest $scheduleQuests
 * @property-read  ScheduleLounge $scheduleLounges
 * @property-read  ScheduleLounge $scheduleLounge
 * @property-read  BookingHoliday $bookingHoliday
 * @property-read  BookingCertificate $bookingCertificate
 */
class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'type',
        'status',
        'city_id',
    ];

    protected $casts = [
        'type' => BookingType::class,
        'status' => BookingStatus::class,
    ];

    protected static function booted(): void
    {
        static::updated(function (self $model) {
            if ($model->isDirty('status') && $model->status->value == BookingStatus::CANCELLED->value) {
                if ($model->type->value == BookingType::QUEST->value) {
                    $model->timeslots()->update(['is_active' => true]);
                    $model->bookingScheduleQuest()->forceDelete();
                } else if ($model->type->value == BookingType::LOUNGE->value) {
                    $model->bookingScheduleLounge()->forceDelete();
                }
                $model->delete();
            }
        });

        static::deleting(function (self $model) {
            if ($model->timeslots()->exists()) {
                $model->timeslots()->update(['is_active' => true]);
                $model->bookingScheduleQuest()->delete();
            } else if ($model->bookingScheduleLounge()->exists()) {
                $model->bookingScheduleLounge()->delete();
            } else if ($model->bookingHoliday()->exists()) {
                $model->bookingHoliday()->delete();
            } else if ($model->bookingCertificate()->exists()) {
                $model->bookingCertificate()->delete();
            }
        });

        static::forceDeleting(function (self $model) {
            match ($model->type->value) {
                BookingType::QUEST->value => $model->bookingScheduleQuest()->forceDelete(),
                BookingType::LOUNGE->value => $model->bookingScheduleLounge()->forceDelete(),
                BookingType::HOLIDAY->value => $model->bookingHoliday()->forceDelete(),
                BookingType::CERTIFICATE->value => $model->bookingCertificate()->forceDelete(),
            };
        });

        static::restoring(function (self $model) {
            if ($model->type->value == BookingType::HOLIDAY->value) {
                $model->bookingHoliday()->restore();
            } else if ($model->type->value == BookingType::CERTIFICATE->value) {
                $model->bookingCertificate()->restore();
            }
        });
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function bookingScheduleQuest(): HasOne
    {
        return $this->hasOne(BookingScheduleQuest::class);
    }

    public function bookingScheduleLounge(): HasOne
    {
        return $this->hasOne(BookingScheduleLounge::class)->withTrashed();
    }

    public function bookingHoliday(): HasOne
    {
        return $this->hasOne(BookingHoliday::class);
    }

    public function bookingCertificate(): HasOne
    {
        return $this->hasOne(BookingCertificate::class);
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(Timeslot::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }

    public function scheduleLounges(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleLounge::class, 'booking_schedule_lounges')
            ->withPivot(['comment']);
    }
}
