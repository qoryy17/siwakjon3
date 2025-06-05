<?php

namespace App\Models\Pengaturan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AIModel extends Model
{
    use HasFactory;
    protected $table = 'sw_ai_model';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ai_model',
        'prompt_catatan_rapat',
        'prompt_kesimpulan_rapat',
    ];

    public $timestamps = true;
}
