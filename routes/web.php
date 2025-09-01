<?php

use App\Http\Controllers\Api\CVInformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ComponentController;
use App\Models\Portfolio;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ContactController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.dashboard');
    Route::prefix('/profile')->middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminProfileController::class, 'index'])->name('admin.profile'); // Dikkat: '.index' yok
        Route::put('/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/avatar', [AdminProfileController::class, 'updateAvatar'])->name('admin.profile.avatar');
        Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');
    });
    // İletişim mesajları için rotalar
    Route::prefix('contacts')->middleware(['auth:admin'])->group(function () {
        Route::post('/{id}/read', [ContactController::class, 'markAsRead'])->name('admin.contacts.read');
        Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('admin.contacts.reply');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
        Route::get('/{id}', [ContactController::class, 'show'])->name('admin.contacts.show');
    });

    Route::get('/inbox', function () {
        return view('admin.pages.inbox');
    })->name('admin.inbox');

    Route::get('/settings', function () {
        return view('admin.pages.settings');
    })->name('admin.settings');

    Route::get('/logout', function () {
        
        return view('admin.pages.logout');
    })->name('admin.logout');

    Route::get('/cvlist', function () {
        return view('admin.pages.cvlist');
    })->name('admin.cvlist');

    Route::get('/experiences', function () {
        return view('admin.pages.experiences');
    })->name('admin.experiences');

    Route::get('/services', function () {
        return view('admin.pages.services');
    })->name('admin.services');

    Route::get('/skills', function () {
        return view('admin.pages.skills');
    })->name('admin.skills');

    Route::get('/testimonials', function () {
        return view('admin.pages.testimonials');
    })->name('admin.testimonials');

    Route::get('/portfolios', function () {
        return view('admin.pages.portfolios');
    })->name('admin.portfolios');

    Route::get('/portfolioCategories', function () {
        return view('admin.pages.portfolioCategories');
    })->name('admin.portfolioCategories');

    Route::get('/portfolios/images/{id}', function ($id) {
        // Portfolyo ID'sini kullanarak portfolyo verisini çek
        $portfolio = Portfolio::findOrFail($id);

        // Portfolyo verisini view'a aktar
        return view('admin.pages.portfolioImages', [
            'portfolio' => $portfolio
        ]);
    })->name('admin.portfolioImages');



});
