<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use App\Enums\StatusPegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'jenis_kelamin' => JenisKelamin::class,
        'status_pegawai' => StatusPegawai::class,
    ];

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }

    public function bawahans()
    {
        return $this->hasMany(Pegawai::class, 'atasan_id');
    }

    public function jabatans()
    {
        return $this->belongsToMany(MJabatan::class, 'pegawai_jabatan', 'pegawai_id', 'jabatan_id');
    }

    public function terapisAnaks()
    {
        return $this->hasMany(AnakTahunAjar::class, 'terapis_id');
    }

    public function keyTerapisAnaks()
    {
        return $this->hasMany(AnakTahunAjar::class, 'key_terapis_id');
    }
}
