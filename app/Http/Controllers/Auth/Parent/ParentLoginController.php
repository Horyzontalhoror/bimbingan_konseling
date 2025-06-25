<?php

namespace App\Http\Controllers\Auth\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.parent.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('parent')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('parent.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('parent.login'));
    }
}
