<?php

namespace Database\Seeders;

use App\Enums\User\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'user_type' => UserTypeEnum::ADMIN->value
        ]);
    }
}
