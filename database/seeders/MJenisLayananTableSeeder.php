<?php

namespace Database\Seeders;

use App\Models\MJenisLayanan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MJenisLayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $data = [
            ['id' => 1, 'nama' => 'Pengayaan', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Reguler', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Transisi', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Pendampingan', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJenisLayanan::insert($data);
    }
}
