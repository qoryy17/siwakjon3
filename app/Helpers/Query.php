<?php

namespace App\Helpers;

use App\Models\Pengaturan\UnitKerjaModel;
use App\Models\Manajemen\ManajemenRapatModel;

class Query
{
    public static function objekPengawasan()
    {
        return UnitKerjaModel::orderBy('unit_kerja', 'asc')->get();
    }

    public static function getMonitoringRapat()
    {
        return ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->whereYear('created_at', date('Y'))->get();
    }
}
