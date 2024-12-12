<?php

namespace App\Models\Pengguna;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JabatanModel extends Model
{
    use HasFactory;

    protected $table = 'sw_unit_kerja';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jabatan',
        'kode_jabatan',
        'aktif',
    ];

    public $timestamps = true;

    public function pegawai(): HasOne{
        return $this->hasOne(PegawaiModel::class);
    }
}
