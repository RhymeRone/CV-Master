<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\View;
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
        // Bu ayarlar Laravel 11 için ZORUNLU - Yorum satırlarını kaldır
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Özel stateful domain ayarları (kesinlikle açalım)
        config([
            'sanctum.stateful' => explode(',', env(
                'SANCTUM_STATEFUL_DOMAINS',
                '127.0.0.1,127.0.0.1:8000,localhost,localhost:8000'
            ))
        ]);

        // Cookie şifrelemeyi doğru şekilde yapılandır
        config(['session.domain' => null]);

        // SameSite politikasını ayarla
        config(['session.same_site' => 'lax']);

        // Cookie güvenliğini sağla
        config(['session.secure' => request()->secure()]);

        // Admin paneline ait tüm view'lara admin modelini otomatik ekle
        View::composer('admin.*', function ($view) {
            $view->with('admin', auth()->guard('admin')->user());
        });
    }
}
