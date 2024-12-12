<?php

namespace App\Models\Pengguna;

use App\Models\Manajemen\ManajemenRapatModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PejabatPenggantiModel extends Model
{
    use HasFactory;

    protected $table = 'sw_pejabat_pengganti';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nip',
        'pejabat',
        'aktif',
    ];

    public $timestamps = true;

    public function manajemenRapat(): BelongsTo{
        return $this->belongsTo(ManajemenRapatModel::class);
    }

}
