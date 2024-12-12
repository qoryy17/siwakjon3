<?php

namespace App\Models\Pengaturan;

use App\Models\Hakim\HakimPengawasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function hakimPengawas(): BelongsTo{
        return $this->belongsTo(HakimPengawasModel::class);
    }
}
