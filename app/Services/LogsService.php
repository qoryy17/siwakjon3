<?php
namespace App\Services;

use App\Models\Pengaturan\LogsModel;
use Illuminate\Support\Facades\Auth;

class LogsService
{

    public static function saveLogs($activity)
    {
        LogsModel::create(
            [
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' ' . $activity . ', timestamp ' . now()
            ]
        );
    }
}
