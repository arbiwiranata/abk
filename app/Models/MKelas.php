<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKelas extends Model
{
    protected $table = 'm_kelas';
    use HasFactory;

    protected $guarded = [];

    public function mJenjangPendidikan()
    {
        return $this->belongsTo(MJenjangPendidikan::class, 'jenjang_pendidikan_id');
    }

    public function anaks()
    {
        return $this->hasMany(Anak::class, 'kelas_id');
    }
}
