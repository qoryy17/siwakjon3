<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\RouteLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\AuthRequest;

class AuthenticationController extends Controller
{
    public function login(AuthRequest $request): RedirectResponse|string
    {
        // Validated all request incoming
        $request->validated();

        $credentials = [
            'email' => htmlspecialchars($request->input('email')),
            'password' => htmlspecialchars($request->input('password')),
        ];

        // Checking existing email, password and active before attempt login !
        $existingUser = User::where('email', $credentials['email'])->first();
        if (!$existingUser) {
            return redirect()->back()->with('error', 'Email tidak terdaftar !')->withInput();
        }

        if (!Hash::check($credentials['password'], $existingUser->password)) {
            return redirect()->back()->with('error', 'Password salah !')->withInput();
        }

        if ($existingUser->active == 0) {
            return redirect()->back()->with('error', 'Akun anda sedang terblokir !')->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->with('error', 'Login gagal, periksa ulang email dan password anda !')->withInput();
        }

        Auth::login($existingUser, true);
        $request->session()->regenerate();
        $intended = RouteLink::homeIntended(Auth::user()->roles);
        // Saving logs activity
        $activity = 'Melakukan login dengan email : ' . $credentials['email'];
        \App\Services\LogsService::saveLogs($activity);
        return redirect()->intended($intended);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('signin');
    }
}
