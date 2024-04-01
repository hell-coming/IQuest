<?php

namespace Database\Seeders;

use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HolidaySeeder::class,
            CorporatePackagesSeeder::class,
            ContactTypeSeeder::class,
        ]);

        User::query()->firstOrCreate([
            'login' => 'admin',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('admin123'),
            'role' => Role::ADMIN->value,
        ]);
    }
}
