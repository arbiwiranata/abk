<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumTarget extends Model
{
    protected $table = 'kurikulum_target';
    use HasFactory;

    protected $guarded = [];

    public function kurikulumAspek()
    {
        return $this->belongsTo(KurikulumAspek::class, 'kurikulum_aspek_id');
    }

    public function kurikulumKegiatans()
    {
        return $this->hasMany(KurikulumKegiatan::class, 'kurikulum_target_id');
    }
}
