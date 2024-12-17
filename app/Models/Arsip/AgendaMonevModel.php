<?php

namespace App\Models\Arsip;

use App\Models\Pengaturan\UnitKerjaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaMonevModel extends Model
{
    use HasFactory;

    protected $table = 'sw_agenda_monev';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nomor_agenda',
        'unit_kerja_id',
        'aktif',
        'dibuat',
    ];

    public $timestamps = true;

    public function arsipMonev(): BelongsTo
    {
        return $this->belongsTo(ArsipMonevModel::class);
    }

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerjaModel::class);
    }
}
