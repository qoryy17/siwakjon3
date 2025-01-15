<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemuanWasbidModel extends Model
{
    use HasFactory;

    protected $table = 'sw_temuan_pengawasan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pengawasan_bidang_id',
        'objek_pengawasan',
        'judul',
        'kondisi',
        'kriteria',
        'sebab',
        'akibat',
        'rekomendasi',
        'waktu_penyelesaian',
    ];

    public $timestamps = true;

    public function pengawasanBidang(): BelongsTo
    {
        return $this->belongsTo(PengawasanBidangModel::class);
    }
}
