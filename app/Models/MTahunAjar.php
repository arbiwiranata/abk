<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTahunAjar extends Model
{
    protected $table = 'm_tahun_ajar';
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_berakhir' => 'date',
    ];

    public function anaks()
    {
        return $this->hasMany(AnakTahunAjar::class, 'tahun_ajar_id');
    }
}
