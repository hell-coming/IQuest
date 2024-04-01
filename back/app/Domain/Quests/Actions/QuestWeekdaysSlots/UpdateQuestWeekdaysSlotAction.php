<?php

namespace App\Domain\Quests\Actions\QuestWeekdaysSlots;

use App\Domain\Quests\Models\QuestWeekdaysSlot;
use App\Domain\Schedules\Models\ScheduleQuest;

class UpdateQuestWeekdaysSlotAction
{
    public function execute(QuestWeekdaysSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests;
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
