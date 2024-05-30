<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHambatan extends Model
{
    protected $table = 'm_hambatan';
    use HasFactory;

    protected $guarded = [];

    public function mJenisHambatan()
    {
        return $this->belongsTo(MJenisHambatan::class, 'jenis_hambatan_id');
    }

    public function kurikulums()
    {
        return $this->hasMany(Kurikulum::class, 'hambatan_id');
    }

    public function matriksPerencanaans()
    {
        return $this->hasMany(MatriksPerencanaan::class, 'hambatan_id');
    }

    public function anaks()
    {
        return $this->belongsToMany(Anak::class, 'anak_hambatan', 'hambatan_id', 'anak_id');
    }

    public static function groupHambatans()
    {
        $jenisHambatans = MJenisHambatan::with('mHambatans')->get();

        $options = [];

        foreach ($jenisHambatans as $jenisHambatan) {
            $group = [
                'label' => $jenisHambatan->nama,
                'options' => [],
            ];

            foreach ($jenisHambatan->mHambatans as $hambatan) {
                $group['options'][$hambatan->id] = $hambatan->nama;
            }

            $options[$jenisHambatan->nama] = $group['options'];
        }

        return $options;
    }
}
