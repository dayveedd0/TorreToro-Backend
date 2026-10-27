<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure default Super Admin exists
        User::firstOrCreate(
            ['email' => 'admin@torretoro.com'],
            [
                'name' => 'Adeboye Damilola',
                'password' => Hash::make('password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'phone' => '+234 813 600 1221',
                'is_active' => true,
            ]
        );

        $this->call([
            DomainSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
            LiveContentSeeder::class,
        ]);
    }
}
