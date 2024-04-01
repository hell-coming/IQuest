<?php

namespace App\Domain\Contacts\Models;

use App\Domain\Locations\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Contact
 *
 * @property int $id Идентификатор контакта
 * @property int $city_id Идентификатор города
 * @property int $contact_type_id Идентификатор типа контакта
 * @property string $value Значение контакта
 *
 * @property-read City $city
 * @property-read ContactType $contactType
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'contact_type_id',
        'value',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class);
    }
}
