<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

        // // // CSRF token'ı yeniliyoruz
        $request->session()->regenerate();

        Auth::guard('admin')->login($admin, $request->boolean('remember', false));

        // Debug bilgisi ekle
        $isAuthenticated = Auth::guard('admin')->check();
        $authenticatedUser = Auth::guard('admin')->user();


        return response()->json([
            'success' => true,
            'user' => $admin,
            'debug' => [
                'isAuthenticated' => $isAuthenticated,
                'authenticatedUser' => $authenticatedUser,
                'sessionId' => $request->session()->getId()
            ]
        ]);
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tüm çerezleri temizle
        foreach ($request->cookies as $name => $value) {
            Cookie::queue(Cookie::forget($name));
        }

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla çıkış yapıldı'
        ]);
    }
}