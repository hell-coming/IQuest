<?php

namespace App\Console\Commands;

use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleQuestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-quest {cityId} {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create schedule for quests every day';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $timezone = $this->argument('timezone');
        $quests = Quest::whereHas('filial.city', fn($query) => $query->where('timezone', $timezone));
        $currentDate = Carbon::now($timezone);

        $this->deleteSlotsForYesterday($currentDate);

        $currentDate->addDays(30);

        if ($currentDate->isWeekday()) {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekdaysSlots');
        } else {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekendSlots');
        }
    }

    private function deleteSlotsForYesterday(Carbon $currentDate): void
    {
        $scheduleQuests = ScheduleQuest::query()->whereDate('date', $currentDate->copy()->subDay());
        $scheduleQuests->each(function (ScheduleQuest $scheduleQuest) {
            $scheduleQuest->timeslots()
                ->whereDoesntHave('bookingScheduleQuest')
                ->forceDelete();
            $scheduleQuest->timeslots()
                ->whereHas('bookingScheduleQuest')
                ->delete();

            if ($scheduleQuest->timeslots()->doesntExist()) {
                $scheduleQuest->forceDelete();
            }
        });
    }

    private function createScheduleQuests($quests, Carbon $currentDate, $slotType): void
    {
        $quests->each(function ($quest) use ($currentDate, $slotType) {
            $scheduleQuest = $quest->scheduleQuests()->firstOrCreate([
                'date' => $currentDate,
                'quest_id' => $quest->id,
            ]);

            $quest->$slotType->each(function ($slot) use ($scheduleQuest) {
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
