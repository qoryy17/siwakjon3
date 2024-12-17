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
        'agenda_monev_id',
        'judul_monev',
        'tanggal_monev',
        'periode_monev_id',
        'path_monev',
        'status',
        'diunggah',
        'waktu_unggah'
    ];

    public $timestamps = true;

    public function agendaMonev(): BelongsTo
    {
        return $this->belongsTo(AgendaMonevModel::class);
    }

    public function periodeMonev(): BelongsTo
    {
        return $this->belongsTo(PeriodeMonevModel::class);
    }
}
