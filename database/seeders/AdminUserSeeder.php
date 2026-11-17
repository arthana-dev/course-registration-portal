<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');

        $user = User::firstOrNew(['email' => $email]);

        $user->name = 'Portal Administrator';
        $user->password = env('ADMIN_PASSWORD', 'ChangeMe123!');
        $user->is_admin = true;
        $user->email_verified_at = now();

        $user->save();
    }
}
