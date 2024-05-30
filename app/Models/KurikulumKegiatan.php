<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumKegiatan extends Model
{
    protected $table = 'kurikulum_kegiatan';
    use HasFactory;

    protected $guarded = [];

    public function kurikulumTarget()
    {
        return $this->belongsTo(KurikulumTarget::class, 'kurikulum_target_id');
    }

    public function kurikulumIndikators()
    {
        return $this->hasMany(KurikulumIndikator::class, 'kurikulum_kegiatan_id');
    }
}
