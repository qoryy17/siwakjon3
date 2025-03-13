<?php

namespace App\Helpers;

use DateTime;
class TimeSession
{
    public static function istime()
    {
        $time = \Carbon\Carbon::now();
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

    public static function convertDateToIndonesian($datetime)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $date = new DateTime($datetime);

        $day = $date->format('d');
        $month = $months[(int) $date->format('m')];
        $year = $date->format('Y');

        return "$day $month $year";
    }

    public static function convertDayIndonesian($date)
    {
        $day = date('D', strtotime($date));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }

    public static function convertMonthIndonesian($datetime)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $date = new DateTime($datetime);
        $month = $months[(int) $date->format('m')];

        return $month;
    }
}
