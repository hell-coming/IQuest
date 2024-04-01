<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Genre
 *
 * @property int $id - Идентификатор жанра
 * @property string $name - Название жанра
 *
 * @property-read Quest $quests
 */
class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }
}
