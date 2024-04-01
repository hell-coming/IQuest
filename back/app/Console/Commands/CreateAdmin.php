<?php

namespace App\Console\Commands;

use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->ask('What is your name?');
        $login = $this->ask('Enter a login:');
        $password = $this->ask('Enter a password:');

        $this->validateArguments([
            'name' => $name,
            'login' => $login,
            'password' => $password
        ]);

        User::query()->create([
            'name' => $name,
            'login' => $login,
            'password' => Hash::make($password),
            'role' => Role::ADMIN->value,
        ]);

        $this->info('Admin created successfully');
    }

    protected function validateArguments($data)
    {
        $validator = Validator::make($data, [
            'name' => 'min:1',
            'login' => 'unique:users',
            'password' => 'min:8',
        ]);

        if ($validator->fails()) {
            $this->error('The given arguments are invalid.');

            collect($validator->errors()->all())
                ->each(fn($error) => $this->line($error));
            exit;
        }

        return $validator;
    }
}
