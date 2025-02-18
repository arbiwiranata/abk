<?php

namespace Database\Seeders;

use App\Models\MKelas;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        
        $data = [
            ['jenjang_pendidikan_id' => 1, 'nama' => 'Kelompok A', 'urutan' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 1, 'nama' => 'Kelompok B', 'urutan' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '1', 'urutan' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '2', 'urutan' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '3', 'urutan' => 3, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '4', 'urutan' => 4, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '5', 'urutan' => 5, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 2, 'nama' => '6', 'urutan' => 6, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 3, 'nama' => '7', 'urutan' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 3, 'nama' => '8', 'urutan' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 3, 'nama' => '9', 'urutan' => 3, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 4, 'nama' => '10', 'urutan' => 1, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 4, 'nama' => '11', 'urutan' => 2, 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['jenjang_pendidikan_id' => 4, 'nama' => '12', 'urutan' => 3, 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MKelas::insert($data);
    }
}
