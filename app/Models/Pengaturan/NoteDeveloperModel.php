<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteDeveloperModel extends Model
{
    use HasFactory;

    protected $table = 'sw_catatan_pengembang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'catatan',
        'pengembang',
        'aktif',
    ];

    public $timestamps = true;
}
