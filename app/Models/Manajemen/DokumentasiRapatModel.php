<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_dokumentasi_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'detail_rapat_id',
        'path_file_dokumentasi',
    ];

    public $timestamps = true;

    public function detailRapat(): BelongsTo{
        return $this->belongsTo(DetailRapatModel::class);
    }
}
