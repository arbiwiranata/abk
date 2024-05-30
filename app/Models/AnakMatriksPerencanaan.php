<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AnakMatriksPerencanaan extends Pivot
{
    protected $table = 'anak_matriks_perencanaan';

    protected $guarded = [];

    public function anakTahunAjar(): BelongsTo
    {
        return $this->belongsTo(AnakTahunAjar::class, 'anak_tahun_ajar_id');
    }

    public function matriksPerencanaan(): BelongsTo
    {
        return $this->belongsTo(MatriksPerencanaan::class, 'matriks_perencanaan_id');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(MJabatan::class, 'jabatan_id');
    }
}
