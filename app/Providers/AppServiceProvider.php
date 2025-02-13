<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sanctum'a custom token doğrulama mantığı ekle
        Sanctum::getAccessTokenFromRequestUsing(function (Request $request) {
            return $request->bearerToken();
        });

        // Sanctum'a custom user provider ekle
        Auth::viaRequest('sanctum', function (Request $request) {
            $token = $request->bearerToken();
            
            if ($token && cache('admin_token') === $token) {
                return new \stdClass(); // Dummy user object
            }
            
            return null;
        });
    }
}
