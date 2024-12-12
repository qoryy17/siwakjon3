<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlasifikasiSuratModel extends Model
{
    use HasFactory;

    protected $table = 'sw_klasifikasi_surat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_surat',
        'kode_klasifikasi',
        'keterangan',
        'aktif',
    ];

    public $timestamps = true;
}
