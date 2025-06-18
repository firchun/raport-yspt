<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianQuran extends Model
{
    use HasFactory;
    protected $table = 'penilaian_quran';
    protected $guarded = [];
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPenilaianQuran::class, 'id_kategori_quran');
    }
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
    public function tahun_ajaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }
}