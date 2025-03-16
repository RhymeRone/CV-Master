<?php

use App\Http\Controllers\Api\CVInformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ComponentController;
use App\Models\Portfolio;
Route::get('/login', function () {
    return view('auth.login');
})->name('login');




Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.dashboard');

    Route::get('/profile', function () {
        return view('admin.pages.profile');
    })->name('admin.profile');

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
