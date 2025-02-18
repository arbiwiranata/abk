<?php

namespace Database\Seeders;

use App\Models\MJabatan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MJabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $data = [
            ['kode' => 'Psi', 'nama' => 'Psikolog', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'TW', 'nama' => 'Terapis Wicara', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'OT', 'nama' => 'Terapis Okupasi', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'FT', 'nama' => 'Fisioterapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'KT', 'nama' => 'Key Terapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['kode' => 'T', 'nama' => 'Terapis', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJabatan::insert($data);
    }
}
