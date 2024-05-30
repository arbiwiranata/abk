<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';
    use HasFactory;

    protected $guarded = [];

    public function mHambatan()
    {
        return $this->belongsTo(MHambatan::class, 'hambatan_id');
    }

    public function kurikulumAspeks()
    {
        return $this->hasMany(KurikulumAspek::class, 'kurikulum_id');
    }
}