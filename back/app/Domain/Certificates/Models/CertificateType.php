<?php

namespace App\Domain\Certificates\Models;

use App\Domain\Bookings\Models\BookingCertificate;
use App\Traits\HasCover;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CertificateType
 *
 * @property int $id Идентификатор типа сертификата
 * @property string $name Название типа сертификата
 * @property string $description Описание типа сертификата
 * @property float $price Стоимость типа сертификата
 * @property string $cover Изображение типа сертификата
 */
class CertificateType extends Model
{
    use HasFactory, SoftDeletes, HasCover;

    protected $fillable = [
        'name',
        'description',
        'price',
        'cover',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $model) {
            $model->bookingCertificates()->each(function (BookingCertificate $bookingCertificate) {
                $bookingCertificate->delete();
            });
        });

        static::forceDeleting(function (self $model) {
            $model->bookingCertificates()->each(function (BookingCertificate $bookingCertificate) {
                $bookingCertificate->forceDelete();
            });
        });
    }

    public function bookingCertificates(): HasMany
    {
        return $this->hasMany(BookingCertificate::class)->withTrashed();
    }
}
