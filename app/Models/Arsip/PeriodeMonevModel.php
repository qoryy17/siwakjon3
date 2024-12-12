<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodeMonevModel extends Model
{
    use HasFactory;

    protected $table = 'sw_periode_monev';
    protected $primaryKey = 'id';

    protected $fillable = [
        'periode',
        'aktif'
    ];

    public $timestamps = true;

    public function arsipMonev(): BelongsTo{
        return $this->belongsTo(ArsipMonevModel::class);
    }
}
