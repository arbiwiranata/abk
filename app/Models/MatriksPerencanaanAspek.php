<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksPerencanaanAspek extends Model
{
    protected $table = 'matriks_perencanaan_aspek';
    use HasFactory;

    protected $guarded = [];

    public function matriksPerencanaan()
    {
        return $this->belongsTo(MatriksPerencanaan::class, 'matriks_perencanaan_id');
    }

    public function matriksPerencanaanItems()
    {
        return $this->hasMany(MatriksPerencanaanItem::class, 'matriks_perencanaan_aspek_id');
    }
}
