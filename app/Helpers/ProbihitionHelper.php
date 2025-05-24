<?php
namespace App\Helpers;

class ProbihitionHelper
{

    public static function rejectIbadahOnRapat($parameters)
    {
        $senteceDenied = ['ibadah', 'pengajian', 'kebaktian', 'islam', 'kristiani'];
        foreach ($senteceDenied as $value) {
            if (str_contains(strtolower($parameters['perihal']), $value)) {
                return redirect()->back()->with('error', 'Kegiatan ibadah tidak boleh menggunakan sistem ini !')->withInput();
            } elseif (str_contains(strtolower($parameters['acara']), $value)) {
                return redirect()->back()->with('error', 'Kegiatan ibadah tidak boleh menggunakan sistem ini !')->withInput();
            } elseif (str_contains(strtolower($parameters['agenda']), $value)) {
                return redirect()->back()->with('error', 'Kegiatan ibadah tidak boleh menggunakan sistem ini !')->withInput();
            }
        }
    }
}
