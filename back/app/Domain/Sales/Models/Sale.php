<?php

namespace App\Domain\Sales\Models;

use App\Domain\Locations\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;

/**
 * Class Sale
 *
 * @property int $id Идентификатор
 * @property string $header Заголовок
 * @property string $description Описание
 * @property string $front_image Переднее изображение
 * @property string $back_image Заднее изображение
 * @property bool $is_active Отображение на сайте
 *
 * @property City $city Город
 */
class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'header',
        'description',
        'front_image',
        'back_image',
        'is_active',
        'city_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::updated(function (self $model) {
            if ($model->isDirty('front_image')) {
                Storage::delete('public/' . $model->getOriginal('front_image'));
            }
            if ($model->isDirty('back_image')) {
                Storage::delete('public/' . $model->getOriginal('back_image'));
            }
        });

        static::deleting(function (self $model) {
            Storage::delete('public/' . $model->front_image);
            Storage::delete('public/' . $model->back_image);
        });
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
