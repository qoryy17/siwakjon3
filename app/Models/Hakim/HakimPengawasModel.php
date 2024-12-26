<?php

namespace App\Models\Hakim;

use App\Models\Pengaturan\UnitKerjaModel;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HakimPengawasModel extends Model
{
    use HasFactory;

    protected $table = 'sw_hakim_pengawas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pegawai_id',
        'unit_kerja_id',
        'aktif',
    ];

    public $timestamps = true;

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(PegawaiModel::class, 'id');
    }

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerjaModel::class);
    }
}
