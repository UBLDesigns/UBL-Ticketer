<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Doe',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'isadmin' => true,
                'client' => 'UBL Designs',
                'remember_token' => Str::random(10)

            ],
            [
                'name' => 'Jane Doe',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'email' => 'customer@customer.com',
                'email_verified_at' => now(),
                'isadmin' => true,
                'client' => 'Nelsons PCB',
                'remember_token' => Str::random(10)

            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}