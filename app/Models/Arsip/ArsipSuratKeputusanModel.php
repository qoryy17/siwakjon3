<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArsipSuratKeputusanModel extends Model
{
    use HasFactory;

    protected $table = 'sw_arsip_sk';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nomor',
        'judul',
        'tanggal_terbit',
        'path_file_sk',
        'status',
        'diunggah'
    ];

    public $timestamps = true;
}
