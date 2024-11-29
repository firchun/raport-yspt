<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarPenilaian extends Model
{
    use HasFactory;
    protected $table = 'komentar_penilaian';
    protected $guarded = [];
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
    public function tahun_ajaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }
}
