<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Identity;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'photo' => '/assets/images/faces/1.jpg'
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'photo' => '/assets/images/faces/1.jpg'
        ]);

        Identity::create([
            'app_name' => 'Task Assignment',
            // 'app_logo' => 'Task Assignment',
            'app_authorization' => 'key=AAAAX4bqqMs:APA91bGm76Hqu8z_YZfeEtuS7KenY99AG69HKOJwFD6lUDVjPlC6OM8JiSy2BT0DXv8IZFqL6XjfhYiWrr1PY3SUIIg9qhnwcRBzTdJc1b2rafIh_ps2-_RpWeUwOnn7JUWdm-fFfmpE',
            'app_mobile_name' => 'pushnotificationapp',
        ]);
    }
}
