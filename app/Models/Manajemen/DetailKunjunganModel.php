<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailKunjunganModel extends Model
{
    protected $table = 'sw_detail_kunjungan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kunjungan_pengawasan_id',
        'tanggal',
        'agenda',
        'waktu',
        'agenda',
        'pembahasan',
        'hakim_pengawas_id'
    ];


    public $timestamps = true;

    public function kunjunganPengawasan(): BelongsTo
    {
        return $this->belongsTo(KunjunganPengawasanModel::class);
    }
}
