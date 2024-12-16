<?php

namespace App\Models\Pengaturan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hakim\HakimPengawasModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKerjaModel extends Model
{
    use HasFactory;

    protected $table = 'sw_unit_kerja';
    protected $primaryKey = 'id';

    protected $fillable = [
        'unit_kerja',
        'aktif',
    ];

    public $timestamps = true;

    public function hakimPengawas(): BelongsTo
    {
        return $this->belongsTo(HakimPengawasModel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
