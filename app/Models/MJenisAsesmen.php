<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisAsesmen extends Model
{
    protected $table = 'm_jenis_asesmen';
    use HasFactory;

    protected $guarded = [];

    public function anaks()
    {
        return $this->hasMany(AnakAsesmen::class, 'jenis_asesmen_id');
    }
}
