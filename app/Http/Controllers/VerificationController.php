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
        $request->validate([
            'search' => 'string'
        ]);

        if ($request->search) {
            $searchData = $this->search(htmlspecialchars($request->search));
        } else {
            $searchData = null;
        }

        $data = [
            'title' => 'Pencarian Dokumen ' . env('APP_NAME'),
            'result' => $searchData
        ];

        return view('verification.verification', $data);
    }

    protected function search($search)
    {
        $manajemenRapat = ManajemenRapatModel::with('detailRapat')->with('klasifikasiRapat')->where('kode_rapat', '=', $search)->first();

        if (!$manajemenRapat) {
            return redirect()->route('verification')->with('error', 'Pencarian dokumen tidak ditemukan !')->withInput();
        }

        if ($manajemenRapat->klasifikasiRapat->rapat == 'Pengawasan') {
            $pengawasan = PengawasanBidangModel::where('detail_rapat_id', '=', $manajemenRapat->detailRapat->id)->first();
        } else {
            $pengawasan = null;
        }

        $collectData = [
            'rapat' => $manajemenRapat,
            'pengawasan' => $pengawasan,
        ];

        return $collectData;
    }
}
