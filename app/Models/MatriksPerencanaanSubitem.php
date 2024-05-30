<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksPerencanaanSubitem extends Model
{
    protected $table = 'matriks_perencanaan_subitem';
    use HasFactory;
    
    protected $guarded = [];

    public function matriksPerencanaanItem()
    {
        return $this->belongsTo(MatriksPerencanaanItem::class, 'matriks_perencanaan_item_id');
    }
}
