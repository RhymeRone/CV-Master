<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DebugAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::debug('DebugAuthMiddleware çalışıyor');
        Log::debug('Request path: ' . $request->path());
        // Giriş yolunda değilse ve admin girişi yapılmamışsa
        if ($request->path() !== 'api/login' && !Auth::guard('admin')->check()) {
            Log::debug('Session/Auth debug', [
                'path' => $request->path(),
                'authenticated' => Auth::guard('admin')->check(),
                'session_id' => $request->session()->getId(),
                'cookies' => $request->cookies->all(),
                'headers' => $request->headers->all()
            ]);
        }

        return $next($request);
    }
} 