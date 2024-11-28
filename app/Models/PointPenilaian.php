<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointPenilaian extends Model
{
    use HasFactory;
    protected $table = 'point_penilaian';
    protected $guarded = [];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }
}