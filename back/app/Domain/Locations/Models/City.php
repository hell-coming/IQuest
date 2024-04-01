<?php

namespace App\Domain\Locations\Models;

use App\Domain\Contacts\Models\Contact;
use App\Domain\Sales\Models\Sale;
use App\Domain\Services\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class City
 *
 * @property int $id - Идентификатор города
 * @property string $name - Название города
 *
 * @property-read Filial $filials
 * @property-read Contact $contacts
 * @property-read Sale $sales
 * @property-read Service $services
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'timezone',
    ];

    public function filials(): HasMany
    {
        return $this->hasMany(Filial::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
