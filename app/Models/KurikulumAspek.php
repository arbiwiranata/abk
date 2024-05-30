<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KurikulumAspek extends Model
{
    protected $table = 'kurikulum_aspek';
    use HasFactory;

    protected $guarded = [];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    public function kurikulumTargets()
    {
        return $this->hasMany(KurikulumTarget::class, 'kurikulum_aspek_id');
    }
}
