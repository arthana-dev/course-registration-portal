<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('course-portal.admin.email');
        $password = config('course-portal.admin.password');

        if (! $email || ! $password) {
            return;
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Portal Administrator',
                'password' => $password,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
