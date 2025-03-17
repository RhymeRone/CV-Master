<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $admin = Admin::where('email', $request->email)->first();
        
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Girdiğiniz bilgiler hatalı.',
                'errors' => [
                    'email' => ['Girdiğiniz e-posta veya şifre hatalı.']
                ]
            ], 401);
        }
        
        // Token'ı veritabanında sakla (sanctum yapıyor)
        $token = $admin->createToken('admin-token', ['admin'], now()->addDay())->plainTextToken;
        
        return response()->json([
            'success' => true,
            'token' => $token,
            'type' => 'Bearer',
            'expires_in' => 86400 // 24 saat
        ]);
    }
    public function logout(Request $request)
    {
        // Token kontrolü yap
        if (!$request->user('admin') || !$request->user('admin')->currentAccessToken()) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz veya eksik token. Çıkış yapılamadı.'
            ], 401);
        }
        
        // Token geçerliyse sil
        $request->user('admin')->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Başarıyla çıkış yapıldı'
        ]);
    }
}