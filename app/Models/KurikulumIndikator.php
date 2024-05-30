<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumIndikator extends Model
{
    protected $table = 'kurikulum_indikator';
    use HasFactory;
    
    protected $guarded = [];

    public function kurikulumKegiatan()
    {
        return $this->belongsTo(KurikulumKegiatan::class, 'kurikulum_kegiatan_id');
    }
}
