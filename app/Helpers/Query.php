<?php

namespace App\Helpers;

use App\Models\Pengaturan\UnitKerjaModel;

class Query
{
    public static function objekPengawasan()
    {
        return UnitKerjaModel::orderBy('unit_kerja', 'asc')->get();
    }
}
