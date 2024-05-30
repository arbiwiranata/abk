<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksPerencanaanItem extends Model
{
    protected $table = 'matriks_perencanaan_item';
    use HasFactory;

    protected $guarded = [];

    public function matriksPerencanaanAspek()
    {
        return $this->belongsTo(MatriksPerencanaanAspek::class, 'matriks_perencanaan_aspek_id');
    }

    public function matriksPerencanaanSubitems()
    {
        return $this->hasMany(MatriksPerencanaanSubitem::class, 'matriks_perencanaan_item_id');
    }
}
