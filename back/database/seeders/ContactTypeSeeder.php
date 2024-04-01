<?php

namespace Database\Seeders;

use App\Domain\Contacts\Models\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['Номер телефона', false],
            ['Почта', false],
            ['YouTube', true],
            ['VK', true],
            ['Telegram', true],
            ['Instagram', true],
        ];

        foreach ($data as $value) {
            ContactType::firstOrCreate([
                'name' => $value[0],
                'is_social' => $value[1],
            ]);
        }
    }
}
