<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksPerencanaan extends Model
{
    protected $table = 'matriks_perencanaan';
    use HasFactory;

    protected $guarded = [];

    public function mHambatan()
    {
        return $this->belongsTo(MHambatan::class, 'hambatan_id');
    }

    public function matriksPerencanaanAspeks()
    {
        return $this->hasMany(MatriksPerencanaanAspek::class, 'matriks_perencanaan_id');
    }
}
