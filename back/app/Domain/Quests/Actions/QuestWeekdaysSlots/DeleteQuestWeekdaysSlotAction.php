<?php

namespace App\Domain\Quests\Actions\QuestWeekdaysSlots;

use App\Domain\Quests\Models\QuestWeekdaysSlot;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Schedules\Models\Timeslot;
use Carbon\Carbon;

class DeleteQuestWeekdaysSlotAction
{
    public function execute(QuestWeekdaysSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests->filter(function (ScheduleQuest $scheduleQuest) use ($slot) {
            return Carbon::parse($scheduleQuest->date)->isWeekday();
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
