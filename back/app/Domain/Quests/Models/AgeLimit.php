<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class AgeLimit
 *
 * @property int $id - Идентификатор возрастного ограничения
 * @property int $limit = Возрастное ограничение
 *
 * @property-read Quest $quests
 */
class AgeLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'limit'
    ];

    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }
}
