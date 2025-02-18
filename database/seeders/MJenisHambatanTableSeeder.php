<?php

namespace Database\Seeders;

use App\Models\MJenisHambatan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MJenisHambatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $data = [
            ['id' => 1, 'nama' => 'Disabilitas Fisik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 2, 'nama' => 'Disabilitas Intelektual', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 3, 'nama' => 'Disabilitas Mental', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['id' => 4, 'nama' => 'Disabilitas Sensorik', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJenisHambatan::insert($data);
    }
}
