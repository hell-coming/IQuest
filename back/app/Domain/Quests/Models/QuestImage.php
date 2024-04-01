<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Class QuestImage
 *
 * @property int $id - Идентификатор картинки
 * @property string $image - Путь к картинке
 * @property int $quest_id - Идентификатор квеста
 *
 * @property-read Quest $quest
 */
class QuestImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'quest_id'
    ];

    protected static function booted(): void
    {
        static::updated(function (self $model) {
            if ($model->isDirty('image')) {
                Storage::delete('public/' . $model->getOriginal('image'));
            }
        });

        static::deleting(function (self $model) {
            Storage::delete('public/' . $model->image);
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
