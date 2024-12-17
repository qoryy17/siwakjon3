<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetKodeRapatModel extends Model
{
    use HasFactory;

    protected $table = 'sw_set_kode_rapat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_rapat_dinas',
        'kode_pengawasan',
    ];

    public $timestamps = true;
}
