<?php

namespace Database\Seeders;

use App\Models\MJenisAsesmen;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MJenisAsesmenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        $data = [
            ['nama' => 'Tes Pendengaran', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ];

        MJenisAsesmen::insert($data);
    }
}
