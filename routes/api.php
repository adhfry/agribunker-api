<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// cek auth
Route::get('/cek/auth', function (Request $request) {
    if ($request->user()) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user(),
            'message' => 'User sudah login',
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => 'User belum login',
        ], 401); // Mengembalikan status 401 Unauthorized
    }
});

Route::post('/login', [AuthController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);
});