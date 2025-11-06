<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'parthishwaran7545@gmail.com'], // Find by email
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists. Updated successfully!');
        }
        
        $this->command->info('Email: parthishwaran7545@gmail.com');
        $this->command->info('Password: admin123');
    }
}