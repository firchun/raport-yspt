<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianSantri extends Model
{
    use HasFactory;
    protected $table = 'penilaian_santri';
    protected $guarded = [];
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
    public function tahun_ajaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }
    public function point(): BelongsTo
    {
        return $this->belongsTo(PointPenilaian::class, 'id_point');
    }
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori');
    }
}
