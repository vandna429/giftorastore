<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('admin.login'); 
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Hardcoded admin credentials
        $adminEmail = 'admin@example.com';
        $adminPassword = 'secret123';

        if ($email === $adminEmail && $password === $adminPassword) {
            $user = \App\Models\User::firstOrCreate(
                ['email' => $adminEmail],
                ['name' => 'Admin', 'password' => bcrypt($adminPassword)]
            );

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
