<?php

namespace Database\Seeders;

use App\Domain\Holidays\Enums\HolidayType;
use App\Domain\Holidays\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporatePackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $corporateHoliday = Holiday::where('type', HolidayType::CORPORATE->value)->first();
        $packages = [
            [
                'name' => 'Корпоратив',
                'description' => 'Описание пакета',
                'price' => 1,
                'is_active' => true,
                'sequence_number' => 1,
            ],
        ];

        foreach ($packages as $package) {
            $corporateHoliday->packages()->firstOrCreate($package);
        }
    }
}
