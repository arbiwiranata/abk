<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJabatan extends Model
{
    protected $table = 'm_jabatan';
    use HasFactory;

    protected $guarded = [];

    public function pegawais()
    {
        return $this->belongsToMany(MJabatan::class, 'pegawai_jabatan', 'jabatan_id', 'pegawai_id');
    }
}
