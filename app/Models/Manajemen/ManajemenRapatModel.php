<?php

namespace App\Models\Manajemen;

use App\Models\Pengguna\PejabatPenggantiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManajemenRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_manajemen_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_rapat',
        'nomor_indeks',
        'nomor_dokumen',
        'klasifikasi_rapat_id',
        'dibuat',
        'pejabat_penandatangan',
        '',
    ];

    public $timestamps = true;

    public function detailRapat(): BelongsTo
    {
        return $this->belongsTo(DetailRapatModel::class, 'id', 'manajemen_rapat_id');
    }

    public function klasifikasiRapat(): BelongsTo
    {
        return $this->belongsTo(KlasifikasiRapatModel::class);
    }

    public function pejabatPengganti(): BelongsTo
    {
        return $this->belongsTo(PejabatPenggantiModel::class);
    }


}
