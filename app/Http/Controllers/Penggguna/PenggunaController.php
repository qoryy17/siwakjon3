<?php

namespace App\Http\Controllers\Penggguna;

use App\Models\User;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna\PegawaiModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaturan\UnitKerjaModel;
use App\Http\Requests\Pengguna\AkunRequest;

class PenggunaController extends Controller
{
    public function indexAkunPengguna()
    {
        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Akun Pengguna', 'link' => route('pengguna.akun'), 'page' => 'aria-current="page"']
        ];
        $data = [
            'title' => 'Manajemen Pengguna | Akun Pengguna',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'pengguna' => User::with('unitKerja')->orderBy('created_at', 'desc')->get(),
        ];

        return view('pengguna.data-akun', $data);
    }

    public function formAkunPengguna(Request $request)
    {
        // Checking received from request
        if (Crypt::decrypt($request->param) == 'add') {
            $paramOutgoing = 'save';
            $formTitle = 'Tambah';
            $pengguna = null;
        } elseif (Crypt::decrypt($request->param) == 'edit') {
            $paramOutgoing = 'update';
            $formTitle = 'Edit';
            $pengguna = User::findOrFail(Crypt::decrypt($request->id));
        } else {
            return redirect()->back()->with('error', 'Parameter tidak ditemukan !');
        }

        // Redirect home page for role
        $route = RouteLink::homePage(Auth::user()->roles);

        $breadcumb = [
            ['title' => 'Home', 'link' => $route, 'page' => ''],
            ['title' => 'Manajemen Pengguna', 'link' => 'javascript:void(0);', 'page' => ''],
            ['title' => 'Akun Pengguna', 'link' => route('pengguna.akun'), 'page' => ''],
            ['title' => $formTitle . ' Pengguna', 'link' => 'javascript:void(0);', 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Manajemen Pengguna | ' . $formTitle . ' Pengguna',
            'routeHome' => $route,
            'breadcumbs' => $breadcumb,
            'formTitle' => $formTitle . ' Pengguna',
            'paramOutgoing' => Crypt::encrypt($paramOutgoing),
            'pengguna' => $pengguna,
            'pegawai' => PegawaiModel::orderBy('nip', 'desc')->get(),
            'unitKerja' => UnitKerjaModel::orderBy('unit_kerja', 'asc')->get()
        ];

        return view('pengguna.form-akun', $data);
    }

    public function savePengguna(AkunRequest $request): RedirectResponse
    {
        // Run validated
        $request->validated();

        $pegawai = PegawaiModel::findOrFail($request->input('pegawai'));

        $formData = [
            'name' => $pegawai->nama,
            'email' => htmlspecialchars($request->input('email'))
        ];

        $paramIncoming = Crypt::decrypt($request->input('param'));
        $save = null;

        if ($paramIncoming == 'save') {
            // Run additional validated
            $request->validate([
                'email' => 'required|string|max:255|email|unique:users',
                'password' => [
                    'required',
                    'min:8',
                    'string',
                    'regex:/[A-Z]/', // must contain at least one uppercase letter
                    'regex:/[a-z]/', // must contain at least one lowercase letter
                    'regex:/[0-9]/', // must contain at least one digit
                    'regex:/[@$!%*?&]/', // must contain a special character

                ],
            ], [
                'email.required' => 'Email harus di isi !',
                'email.string' => 'Email harus berupa karakter valid !',
                'email.max' => 'Email maksimal 255 karakter !',
                'email.email' => 'Email harus valid ! contoh : example@local.com',
                'email.unique' => 'Email sudah di gunakan !',
                'password.required' => 'Password harus harus di isi !',
                'password.min' => 'Password harus mengandung 8 karakter !',
                'password.string' => 'Password harus harus berupa karakter valid !',
                'password.regex' => 'Password harus mengandung huruf kapital, angka dan karakter !',
            ]);
            $formData['password'] = Hash::make(htmlspecialchars($request->input('password')));
            $formData['pegawai_id'] = htmlspecialchars($request->input('pegawai'));
            $formData['unit_kerja_id'] = htmlspecialchars($request->input('unitKerja'));
            $formData['active'] = htmlspecialchars($request->input('active'));
            $formData['roles'] = htmlspecialchars($request->input('role'));

            $save = User::create($formData);
            $success = 'Akun Pengguna berhasil di simpan !';
            $error = 'Akun Pengguna gagal di simpan !';
            $activity = 'Menambahkan pengguna : ' . $formData['name'];
        } elseif ($paramIncoming == 'update') {
            $formData = [
                'name' => $pegawai->nama,
                'email' => htmlspecialchars($request->input('email')),
                'pegawai_id' => htmlspecialchars($request->input('pegawai')),
                'unit_kerja_id' => htmlspecialchars($request->input('unitKerja')),
                'active' => htmlspecialchars($request->input('active')),
                'roles' => htmlspecialchars($request->input('role')),
            ];
            // Run additional validated
            if ($request->input('password')) {
                $formData['password'] = Hash::make(htmlspecialchars($request->input('password')));

                $request->validate([
                    'email' => 'required|string|max:255|email',
                    'password' => [
                        'min:8',
                        'string',
                        'regex:/[A-Z]/', // must contain at least one uppercase letter
                        'regex:/[a-z]/', // must contain at least one lowercase letter
                        'regex:/[0-9]/', // must contain at least one digit
                        'regex:/[@$!%*?&]/', // must contain a special character

                    ],
                ], [
                    'email.required' => 'Email harus di isi !',
                    'email.string' => 'Email harus berupa karakter valid !',
                    'email.max' => 'Email maksimal 255 karakter !',
                    'email.email' => 'Email harus valid ! contoh : example@local.com',
                    'password.required' => 'Password harus harus di isi !',
                    'password.min' => 'Password harus mengandung 8 karakter !',
                    'password.string' => 'Password harus harus berupa karakter valid !',
                    'password.regex' => 'Password harus mengandung huruf kapital, angka dan karakter !',
                ]);
            }

            $formData['pegawai_id'] = htmlspecialchars($request->input('pegawai'));
            $formData['unit_kerja_id'] = htmlspecialchars($request->input('unitKerja'));
            $formData['active'] = htmlspecialchars($request->input('active'));
            $formData['roles'] = htmlspecialchars($request->input('role'));

            $search = User::findOrFail(Crypt::decrypt($request->input('id')));

            $save = $search->update($formData);
            $success = 'Akun Pengguna berhasil di perbarui !';
            $error = 'Akun Pengguna gagal di perbarui !';
            $activity = 'Memperbarui pengguna dengan id ' . $request->input('id');
        } else {
            return redirect()->back()->with('error', 'Parameter tidak valid !')->withInput();
        }

        if (!$save) {
            return redirect()->back()->with('error', $error)->withInput();
        }

        // Saving logs activity
        \App\Services\LogsService::saveLogs($activity);
        return redirect()->route('pengguna.akun')->with('success', $success);
    }

    public function deletePengguna(Request $request): RedirectResponse
    {
        // Checking data pegawai on database
        $pegawai = PegawaiModel::findOrFail(Crypt::decrypt($request->id));
        if ($pegawai) {
            // Delete old foto
            if (!empty($pegawai->foto) && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            // Saving logs activity
            $activity = 'Menghapus pegawai : ' . $pegawai->nama;
            \App\Services\LogsService::saveLogs($activity);

            $pegawai->delete();
            return redirect()->route('pengguna.akun')->with('success', 'Akun Pengguna berhasil di hapus !');
        }
        return redirect()->route('pengguna.akun')->with('error', 'Akun Pengguna gagal di hapus !');

    }
}
