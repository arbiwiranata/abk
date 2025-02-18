<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenjangPendidikan extends Model
{
    protected $table = 'm_jenjang_pendidikan';
    use HasFactory;

    protected $guarded = [];

    public function mKelas()
    {
        return $this->hasMany(MKelas::class, 'jenjang_pendidikan_id');
    }

    public function mSekolahs()
    {
        return $this->hasMany(MSekolah::class, 'jenjang_pendidikan_id');
    }
}
