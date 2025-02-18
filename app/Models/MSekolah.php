<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSekolah extends Model
{
    protected $table = 'm_sekolah';
    use HasFactory;

    protected $guarded = [];

    public function mJenjangPendidikan()
    {
        return $this->belongsTo(MJenjangPendidikan::class, 'jenjang_pendidikan_id');
    }

    public function anaks()
    {
        return $this->hasMany(Anak::class, 'sekolah_id');
    }
}
