<?php

namespace App\Models\Manajemen;

use App\Models\Pengaturan\UnitKerjaModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KunjunganPengawasanModel extends Model
{
    protected $table = 'sw_kunjungan_pengawasan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kunjungan',
        'unit_kerja_id',
        'dibuat',
        'path_file_edoc',
        'waktu_unggah'
    ];

    public $timestamps = true;

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerjaModel::class);
    }

    public function detailKunjungan(): BelongsTo
    {
        return $this->belongsTo(DetailKunjunganModel::class);
    }
}
