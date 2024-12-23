<?php

namespace App\Models\Manajemen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EdocWasbidModel extends Model
{
    use HasFactory;

    protected $table = 'sw_edoc_tlhp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pengawasan_bidang_id',
        'path_file_tlhp',
    ];

    public $timestamps = true;

    public function pengawasanBidang(): BelongsTo
    {
        return $this->belongsTo(PengawasanBidangModel::class);
    }
}
