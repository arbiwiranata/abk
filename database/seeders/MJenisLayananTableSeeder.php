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
            ['id' => 1, 'nama' => 'Pengayaan', 'urutan' => 1,'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Reguler', 'urutan' => 2,'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Transisi', 'urutan' => 3,'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Pendampingan', 'urutan' => 4,'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJenisLayanan::insert($data);
    }
}
