<?php

namespace App\Domain\Quests\Models;

use App\Domain\Quests\Actions\QuestWeekendSlots\UpdateQuestWeekendSlotAction;
use App\Domain\Quests\Actions\QuestWeekendSlots\DeleteQuestWeekendSlotAction;
use App\Domain\Quests\Actions\QuestWeekendSlots\CreateQuestWeekendSlotAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuestWeekendSlot
 *
 * @property int $id - Идентификатор
 * @property int $quest_id - Идентификатор квеста
 * @property string $time - Время
 * @property float $price - Цена
 *
 * @property-read Quest $quest
 */
class QuestWeekendSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'time',
        'price',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            resolve(CreateQuestWeekendSlotAction::class)->execute($model);
        });

        static::updating(function (self $model) {
            resolve(UpdateQuestWeekendSlotAction::class)->execute($model);
        });

        static::deleting(function (self $model) {
            resolve(DeleteQuestWeekendSlotAction::class)->execute($model);
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
