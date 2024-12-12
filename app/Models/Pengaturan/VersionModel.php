<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VersionModel extends Model
{
    use HasFactory;

    protected $table = 'sw_versi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'release_date',
        'category',
        'patch_version',
        'note',
    ];

    public $timestamps = true;
}
