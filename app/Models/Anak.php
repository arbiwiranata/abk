<?php

namespace App\Models;

use App\Enums\JenisKelamin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'anak';
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'jenis_kelamin' => JenisKelamin::class,
    ];

    public function mAgama()
    {
        return $this->belongsTo(MAgama::class, 'agama_id');
    }

    public function hambatans()
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
