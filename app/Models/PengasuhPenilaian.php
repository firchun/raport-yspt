<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengasuhPenilaian extends Model
{
    use HasFactory;
    protected $table = 'pengasuh_penilaian';
    protected $guarded = [];
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
    public function pengasuh(): BelongsTo
    {
        return $this->belongsTo(Pengasuh::class, 'id_pengasuh');
    }
    public function tahun_ajaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }
}
