<?php

namespace App\Helpers;

use DateTime;

class TimeSession
{
    public static function istime()
    {
        $time = new DateTime();
        $hour = $time->format('H');

        if ($hour >= 5 && $hour < 12) {
            return 'Pagi'; // 05:00 - 11:59
        } elseif ($hour >= 12 && $hour < 15) {
            return 'Siang'; // 12:00 - 14:59
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Sore'; // 15:00 - 17:59
        } else {
            return 'Malam'; // 18:00 - 04:59
        }
    }

    public static function convertMonthToRoman()
    {
        $month = date('m');
        switch ($month) {
            case '01':
                return 'I';
            case '02':
                return 'II';
            case '03':
                return 'III';
            case '04':
                return 'IV';
            case '05':
                return 'V';
            case '06':
                return 'VI';
            case '07':
                return 'VII';
            case '08':
                return 'VIII';
            case '09':
                return 'IX';
            case '10':
                return 'X';
            case '11':
                return 'XI';
            case '12':
                return 'XII';
            default:
                return 'Invalid Month';
        }
    }
}
