<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AplikasiModel extends Model
{
    use HasFactory;

    protected $table = 'sw_pengaturan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'lembaga',
        'badan_peradilan',
        'wilayah_hukum',
        'kode_satker',
        'satuan_kerja',
        'alamat',
        'provinsi',
        'kota',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'logo',
        'license',
    ];

    public $timestamps = true;
}
