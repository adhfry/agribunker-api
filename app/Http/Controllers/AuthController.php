<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
                'message' => 'Login berhasil',
                'status' => 'success'
            ], 200);
        }

        return response()->json(['message' => 'Login gagal, email atau password salah', 'status' => 'error'], 401);
    }

    public function logout(Request $request)
    {
        // Hapus sesi autentikasi
        Auth::guard('web')->logout();

        // Hapus semua sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus semua token API pengguna
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        // Hapus cookie session Laravel
        $cookie = Cookie::forget('laravel_session');
        $sanctumCookie = Cookie::forget('XSRF-TOKEN');

        return response()->json([
            'message' => 'Logout berhasil'
        ])->withCookie($cookie)->withCookie($sanctumCookie);
    }
}
