<?php

namespace App\Console\Commands;

use App\Domain\Locations\Models\City;
use Artisan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckTimezone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-timezone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking timezone of cities';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $cities = City::pluck('timezone', 'id');

        $cities->each(function ($timezone, $id) {
            if (Carbon::now($timezone)->hour == 0) {
                Artisan::call(ScheduleQuestCommand::class, ['cityId' => $id, 'timezone' => $timezone]);
            }
        });
    }
}
