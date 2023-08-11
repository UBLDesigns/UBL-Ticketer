<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Option;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Option::factory(3)->create();
        Setting::factory(1)->create();
        /* $this->call(User::class); */

        $users = [
            [
                'name' => 'John Doe',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'isadmin' => true,
                'standard' => 25.00,
                'asap' => 35.00,
                'urgent' => 50.00,
                'client' => 'UBL Designs',
                'remember_token' => Str::random(10)

            ],
            [
                'name' => 'Jane Doe',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'email' => 'customer@customer.com',
                'email_verified_at' => now(),
                'isadmin' => true,
                'standard' => 25.00,
                'asap' => 35.00,
                'urgent' => 50.00,
                'client' => 'Nelsons PCB',
                'remember_token' => Str::random(10)

            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
