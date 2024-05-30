<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisLayanan extends Model
{
    protected $table = 'm_jenis_layanan';
    use HasFactory;

    protected $guarded = [];

    public function anaks()
    {
        return $this->hasMany(AnakTahunAjar::class, 'jenis_layanan_id');
    }
}
