<?php

namespace App\Models\Pengguna;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PegawaiModel extends Model
{
    use HasFactory;

    protected $table = 'sw_pegawai';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan_id',
        'foto',
        'aktif',
        'keterangan',
    ];

    public $timestamps = true;

    public function user(): HasOne{
        return $this->hasOne(User::class);
    }

    public function jabatan(): HasOne{
        return $this->hasOne(JabatanModel::class);
    }
}
