<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_detail_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'manajemen_rapat_id',
        'tanggal_rapat',
        'sifat',
        'lampiran',
        'perihal',
        'acara',
        'agenda',
        'jam_mulai',
        'tempat',
        'peserta',
        'keterangan',
        'jam_selesai',
        'pembahasan',
        'pimpinan_rapat',
        'moderator',
        'notulen',
        'catatan',
        'kesimpulan',
        'disahkan',
    ];

    public $timestamps = true;

    public function manajemenRapat(): BelongsTo
    {
        return $this->belongsTo(ManajemenRapatModel::class, 'manajemen_rapat_id', 'id');
    }

    public function pengawasanBidang(): BelongsTo
    {
        return $this->belongsTo(PengawasanBidangModel::class);
    }

    public function dokumentasiRapat(): BelongsTo
    {
        return $this->belongsTo(DokumentasiRapatModel::class);
    }

}
