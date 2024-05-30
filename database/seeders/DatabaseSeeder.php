<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();
        
        // Agama
        $data = [
            ['id' => 1, 'nama' => 'Islam', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Kristen', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Katolik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Hindu', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 5, 'nama' => 'Buddha', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 6, 'nama' => 'Khonghucu', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MAgama::insert($data);

        // Jabatan
        $data = [
            ['kode' => 'Psi', 'nama' => 'Psikolog', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'TW', 'nama' => 'Terapis Wicara', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'OT', 'nama' => 'Terapis Okupasi', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'FT', 'nama' => 'Fisioterapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'KT', 'nama' => 'Key Terapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'T', 'nama' => 'Terapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MJabatan::insert($data);

        // Jenis Asesmen
        $data = [
            ['nama' => 'Tes Pendengaran', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MJenisAsesmen::insert($data);

        // Jenis Hambatan
        $data = [
            ['id' => 1, 'nama' => 'Disabilitas Fisik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Disabilitas Intelektual', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Disabilitas Mental', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Disabilitas Sensorik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MJenisHambatan::insert($data);

        // Jenis Layanan
        $data = [
            ['id' => 1, 'nama' => 'Pengayaan', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Reguler', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Transisi', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Pendampingan', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MJenisLayanan::insert($data);

        // Tahun Ajar
        $data = [
            ['nama' => 'Januari - Juni 2023', 'periode_mulai' => '2023-01-01', 'periode_berakhir' => '2023-06-30', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Juli - Desember 2023', 'periode_mulai' => '2023-07-01', 'periode_berakhir' => '2023-12-31', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Januari - Juni 2024', 'periode_mulai' => '2024-01-01', 'periode_berakhir' => '2024-06-30', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['nama' => 'Juli - Desember 2024', 'periode_mulai' => '2024-07-01', 'periode_berakhir' => '2024-12-31', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        \App\Models\MTahunAjar::insert($data);
    }
}
