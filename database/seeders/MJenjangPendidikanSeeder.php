<?php

namespace Database\Seeders;

use App\Models\MJenjangPendidikan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MJenjangPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        
        $data = [
            ['id' => 1, 'nama' => 'TK', 'urutan' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'SD', 'urutan' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'SMP', 'urutan' => 3, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'SMA/SMK', 'urutan' => 4, 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJenjangPendidikan::insert($data);
    }
}
