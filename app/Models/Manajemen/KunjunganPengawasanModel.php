<?php

namespace App\Models\Manajemen;

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
    ];

    public $timestamps = true;

    public function detailKunjungan(): BelongsTo
    {
        return $this->belongsTo(DetailKunjunganModel::class);
    }
}
