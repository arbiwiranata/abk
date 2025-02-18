<?php

namespace Database\Seeders;

use App\Models\MTahunAjar;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MTahunAjarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $data = [
            ['nama' => 'Januari - Juni 2023', 'periode_mulai' => '2023-01-01', 'periode_berakhir' => '2023-06-30', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Juli - Desember 2023', 'periode_mulai' => '2023-07-01', 'periode_berakhir' => '2023-12-31', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Januari - Juni 2024', 'periode_mulai' => '2024-01-01', 'periode_berakhir' => '2024-06-30', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Juli - Desember 2024', 'periode_mulai' => '2024-07-01', 'periode_berakhir' => '2024-12-31', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MTahunAjar::insert($data);
    }
}
