<?php

namespace App\Domain\Quests\Actions\QuestWeekendSlots;

use App\Domain\Quests\Models\QuestWeekendSlot;
use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;

class UpdateQuestWeekendSlotAction
{
    public function execute(QuestWeekendSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests->filter(function (ScheduleQuest $scheduleQuest) use ($slot) {
            return Carbon::parse($scheduleQuest->date)->isWeekend();
        });
        $dirtyFields = array_keys($slot->getDirty());

        foreach ($dirtyFields as $field) {
            $scheduleQuests->each(function (ScheduleQuest $scheduleQuest) use ($slot, $field) {
                $scheduleQuest->timeslots()
                    ->where($field, $slot->getOriginal($field))
                    ->update([
                        $field => $slot->$field,
                    ]);
            });
        }
    }
}
