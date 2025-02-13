<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThrottleContact
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'contact:' . $request->ip();
        $maxAttempts = config('admin.contact.throttle.max_attempts');
        $decayMinutes = config('admin.contact.throttle.decay_minutes');

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json([
                'message' => 'Çok fazla deneme yaptınız. Lütfen ' . $decayMinutes . ' dakika sonra tekrar deneyin.'
            ], 429);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        return $next($request);
    }
} 