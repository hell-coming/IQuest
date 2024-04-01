<?php

namespace App\Console\Commands;

use App\Domain\Quests\Models\Quest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class RestoreScheduleQuest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restore-schedule-quest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restoring timeslots for schedule quests';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $quests = Quest::all();

        $startDate = Carbon::today();
        $endDate = Carbon::today()->addMonth();

        $workingDays = CarbonPeriod::create($startDate, $endDate);

        foreach ($workingDays as $currentDay) {
            $isWeekend = $currentDay->isWeekend();

            $quests->each(function ($quest) use ($currentDay, $isWeekend) {
                $scheduleQuest = $quest->scheduleQuests()->firstOrCreate([
                    'date' => $currentDay,
                    'quest_id' => $quest->id,
                ]);

                $slots = $isWeekend ? $quest->questWeekendSlots : $quest->questWeekdaysSlots;

                $slots->each(function ($slot) use ($scheduleQuest) {
                    $scheduleQuest->timeslots()->firstOrCreate([
                        'time' => $slot->time,
                        'price' => $slot->price,
                        'is_active' => true,
                        'schedule_quest_id' => $scheduleQuest->id,
                    ]);
                });
            });
        }
    }
}
