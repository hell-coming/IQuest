<?php

namespace App\Domain\Quests\Actions\QuestWeekendSlots;

use App\Domain\Quests\Models\QuestWeekendSlot;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Schedules\Models\Timeslot;
use Carbon\Carbon;

class DeleteQuestWeekendSlotAction
{
    public function execute(QuestWeekendSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests->filter(function (ScheduleQuest $scheduleQuest) use ($slot) {
            return Carbon::parse($scheduleQuest->date)->isWeekend();
        });

        $scheduleQuests->each(function (ScheduleQuest $scheduleQuest) use ($slot) {
            $timeslots = $scheduleQuest->timeslots()
                ->where('time', $slot->time)
                ->where('price', $slot->price);

            $timeslots->each(function (Timeslot $timeslot) {
                if ($timeslot->bookingScheduleQuest()->doesntExist()) {
                    $timeslot->forceDelete();
                } else {
                    $timeslot->delete();
                }
            });
        });
    }
}
