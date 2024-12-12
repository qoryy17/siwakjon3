<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KlasifikasiRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_klasifikasi_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'rapat',
        'kode_klasifikasi',
        'keterangan',
        'aktif',
    ];

    public $timestamps = true;

    public function manajemenRapat(): BelongsTo
    {
        return $this->belongsTo(ManajemenRapatModel::class);
    }
}
