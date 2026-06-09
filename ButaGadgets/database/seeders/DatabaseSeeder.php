<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'username' => 'TestUser', // або 'first_name' => 'Test', залежно від вашої міграції users
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // обов'язково додайте пароль, якщо він потрібен
        ]);
    }
}
