<?php

namespace App\Domain\Quests\Actions\QuestWeekendSlots;

use App\Domain\Quests\Models\QuestWeekendSlot;
use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CreateQuestWeekendSlotAction
{
    public function execute(QuestWeekendSlot $slot): void
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(30);

        $workingDays = CarbonPeriod::create($startDate, $endDate)
            ->addFilter(function ($date) {
                return $date->isWeekend();
            });

        foreach ($workingDays as $currentDay) {
            $scheduleQuest = ScheduleQuest::firstOrCreate([
                'quest_id' => $slot->quest_id,
                'date' => $currentDay,
            ]);

            $scheduleQuest->timeslots()->create([
                'time' => $slot->time,
                'price' => $slot->price,
                'is_active' => true,
            ]);
        }
    }
}
