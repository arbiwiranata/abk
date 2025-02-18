<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'anak';
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'jenis_kelamin' => JenisKelamin::class,
        'tanggal_lahir' => 'date',
        'is_sekolah' => 'boolean',
        'is_aktif' => 'boolean',
    ];

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->tanggal_lahir)->age,
        );
    }

    public function jenjangPendidikan(): Attribute
    {
        return Attribute::make(
            get: fn() => 2,
        );
    }

    public function mAgama()
    {
        return $this->belongsTo(MAgama::class, 'agama_id');
    }

    public function mKelas()
    {
        return $this->belongsTo(MKelas::class, 'kelas_id');
    }

    public function mSekolah()
    {
        return $this->belongsTo(MSekolah::class, 'sekolah_id');
    }

    public function mHambatans()
    {
        return $this->belongsToMany(MHambatan::class, 'anak_hambatan', 'anak_id', 'hambatan_id');
    }

    public function jenisAsesmens()
    {
        return $this->hasMany(AnakAsesmen::class, 'anak_id');
    }

    public function tahunAjars()
    {
        return $this->hasMany(AnakTahunAjar::class, 'anak_id');
    }
}
