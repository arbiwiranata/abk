<?php

namespace Database\Seeders;

use App\Models\MAgama;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MAgamaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        
        $data = [
            ['id' => 1, 'nama' => 'Islam', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Kristen', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Katolik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Hindu', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 5, 'nama' => 'Buddha', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 6, 'nama' => 'Khonghucu', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MAgama::insert($data);
    }
}
