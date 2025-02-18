<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        
        $data = [
            ['name' => 'Admin Adinda Modis', 'email' => 'adminabk@gmail.com', 'password' => Hash::make('12345'), 'created_at' => $timestamp, 'updated_at' => $timestamp]
        ];

        User::insert($data);
    }
}
