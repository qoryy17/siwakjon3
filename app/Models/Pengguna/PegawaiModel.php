<?php

namespace App\Models\Pengguna;

use App\Models\Hakim\HakimPengawasModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PegawaiModel extends Model
{
    use HasFactory;

    protected $table = 'sw_pegawai';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nip',
        'nama',
        'jabatan_id',
        'aktif',
        'keterangan',
        'foto',
    ];

    public $timestamps = true;

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'pegawai_id', 'id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(JabatanModel::class, 'jabatan_id', 'id');
    }

    public function hakimPengawas(): BelongsTo
    {
        return $this->belongsTo(HakimPengawasModel::class);
    }
}
