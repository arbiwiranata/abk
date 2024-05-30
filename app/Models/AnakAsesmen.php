<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnakAsesmen extends Pivot
{
    protected $table = 'anak_asesmen';

    protected $guarded = [];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class, 'anak_id');
    }
 
    public function jenisAsesmen(): BelongsTo
    {
        return $this->belongsTo(MJenisAsesmen::class, 'jenis_asesmen_id');
    }
}
