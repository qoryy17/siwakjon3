<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengawasanBidangModel extends Model
{
    use HasFactory;

    protected $table = 'sw_pengawasan_bidang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pengawasan',
        'detail_rapat_id',
        'objek_pengawasan',
        'deskripsi_pengawasan',
        'kesimpulan',
        'rekomendasi',
        'hakim_pengawas',
        'status',
        'approve_stamp',
    ];

    public $timestamps = true;

    public function detailRapat(): BelongsTo{
        return $this->belongsTo(DetailRapatModel::class);
    }

    public function temuanWasbid(): BelongsTo{
        return $this->belongsTo(TemuanWasbidModel::class);
    }
}
