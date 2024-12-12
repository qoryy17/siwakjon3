<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manajemen\DetailRapatModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EdocRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_edoc_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'detail_rapat_id',
        'path_file_edoc',
    ];

    public $timestamps = true;

    public function detailRapat(): BelongsTo{
        return $this->belongsTo(DetailRapatModel::class);
    }
}
