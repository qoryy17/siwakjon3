<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlasifikasiJabatanModel extends Model
{
    use HasFactory;

    protected $table = 'sw_klasifikasi_jabatan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jabatan',
        'kode_jabatan',
        'keterangan',
        'aktif',
    ];

    public $timestamps = true;

}
