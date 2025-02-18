<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(MAgamaTableSeeder::class);
        $this->call(MJabatanTableSeeder::class);
        $this->call(MJenisAsesmenTableSeeder::class);
        $this->call(MJenisHambatanTableSeeder::class);
        $this->call(MJenisLayananTableSeeder::class);
        $this->call(MJenjangPendidikanSeeder::class);
        $this->call(MKelasSeeder::class);
        $this->call(MTahunAjarTableSeeder::class);
    }
}
