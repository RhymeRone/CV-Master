<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Zaten giriş yapılmış mı kontrol et
        if (cache('admin_token') && $request->bearerToken() === cache('admin_token')) {
            return response()->json([
                'message' => 'Zaten giriş yapılmış'
            ], 400);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($request->email === config('admin.email') && 
            $request->password === config('admin.password')) {
            
            $token = bin2hex(random_bytes(32));
            $lifetime = config('admin.token_lifetime');
            
            cache(['admin_token' => $token], now()->addSeconds($lifetime));
            
            return response()->json([
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => $lifetime
            ]);
        }

        return response()->json([
            'message' => 'Yetkisiz erişim'
        ], 401);
    }

    public function logout()
    {
        cache()->forget('admin_token');
        
        return response()->json([
            'message' => 'Başarıyla çıkış yapıldı'
        ]);
    }
} 