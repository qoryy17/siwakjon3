<?php

namespace App\Models\Pengguna;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(JabatanModel::class);
    }
}
