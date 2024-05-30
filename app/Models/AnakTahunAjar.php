<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnakTahunAjar extends Model
{
    protected $table = 'anak_tahun_ajar';
    use HasFactory;

    protected $guarded = [];

    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class, 'anak_id');
    }
 
    public function tahunAjar(): BelongsTo
    {
        return $this->belongsTo(MTahunAjar::class, 'tahun_ajar_id');
    }

    public function jenisLayanan(): BelongsTo
    {
        return $this->belongsTo(MJenisLayanan::class, 'jenis_layanan_id');
    }

    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    public function terapis(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'terapis_id');
    }

    public function keyTerapis(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'key_terapis_id');
    }

    public function matriksPerencanaans()
    {
        return $this->hasMany(AnakMatriksPerencanaan::class, 'anak_tahun_ajar_id');
    }
}
