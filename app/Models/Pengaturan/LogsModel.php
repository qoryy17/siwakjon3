<?php

namespace App\Models\Pengaturan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogsModel extends Model
{
    use HasFactory;

    protected $table = 'sw_unit_kerja';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'activity',
    ];

    public $timestamps = true;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
