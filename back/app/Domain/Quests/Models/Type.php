<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Type
 *
 * @property int $id - Идентификатор типа
 * @property string $name - Название типа
 *
 * @property-read Quest $quests
 */
class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }
}
