<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJenisHambatan extends Model
{
    protected $table = 'm_jenis_hambatan';
    use HasFactory;

    protected $guarded = [];

    public function mHambatans()
    {
        return $this->hasMany(MHambatan::class, 'jenis_hambatan_id');
    }
}
