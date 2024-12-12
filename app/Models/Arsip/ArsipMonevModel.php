<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipMonevModel extends Model
{
    use HasFactory;

    protected $table = 'sw_arsip_monev';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal_monev',
        'judul_monev',
        'periode_monev',
        'path_laporan_monev_pdf',
        'path_laporan_monev_word',
        'diunggah'
    ];

    public $timestamps = true;

    public function periodeMonev(): BelongsTo{
        return $this->belongsTo(PeriodeMonevModel::class);
    }
}
