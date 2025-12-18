<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Mặc định là user thường
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function login(Request $request) {
        $credentials = $request->validate(['email' => 'required', 'password' => 'required']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->isAdmin()) {
                return redirect()->route('home')->with('success', 'Chào Admin!');
            }
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Sai thông tin đăng nhập']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
