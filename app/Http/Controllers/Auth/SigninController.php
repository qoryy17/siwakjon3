<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SigninController extends Controller
{
    function index(): View
    {
        $data = [
            'title' => env('APP_NAME') . ' | ' . env('APP_DESC')
        ];
        return view('auth.signin', $data);
    }
}
