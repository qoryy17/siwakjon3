<?php

namespace App\Http\Controllers;

use App\Models\Manajemen\ManajemenRapatModel;
use App\Models\Manajemen\PengawasanBidangModel;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        // Run validate
        $request->validate(
            [
                'search' => 'string|uuid'
            ],
            [
                'search.string' => 'Pencarian harus berupa karakter valid !',
                'search.uuid' => 'Kode Dokumen tidak valid !',
            ]
        );

        $keyword = $request->search;

        $searchData = empty($keyword) ? null : $searchData = $this->search($request->search);

        $data = [
            'title' => 'Pencarian Dokumen ' . env('APP_NAME'),
            'result' => $searchData
        ];

        // return $searchData;

        return view('verification.verification', $data);
    }

    protected function search($search)
    {
        $manajemenRapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->where('kode_rapat', '=', $search);

        if ($manajemenRapat->exists()) {

            if ($manajemenRapat->first()->klasifikasiRapat->rapat == 'Pengawasan') {
                $pengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $manajemenRapat->first()->detailRapat->id)->first();
            } else {
                $pengawasan = null;
            }

            $collectData = [
                'rapat' => $manajemenRapat->first(),
                'pengawasan' => $pengawasan,
            ];

            return $collectData;
        }

        return null;
    }
}
