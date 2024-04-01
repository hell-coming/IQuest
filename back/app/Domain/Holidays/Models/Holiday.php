<?php

namespace App\Domain\Holidays\Models;

use App\Domain\Holidays\Enums\HolidayType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Holiday
 *
 * @property int $id Идентификатор праздника
 * @property HolidayType $type Тип праздника
 * @property bool $is_active Статус активности
 *
 * @property-read HolidayPackage[] $holidayPackages
 * @property-read Package[] $packages
 */
class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'is_active',
    ];

    protected $casts = [
        'type' => HolidayType::class,
        'is_active' => 'boolean',
    ];

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'holiday_packages');
    }
}
