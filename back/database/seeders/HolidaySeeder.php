<?php

namespace Database\Seeders;

use App\Domain\Holidays\Enums\HolidayType;
use App\Domain\Holidays\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (HolidayType::cases() as $holidayType) {
            Holiday::query()->firstOrCreate([
                'type' => $holidayType->value,
            ]);
        }
    }
}
