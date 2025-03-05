<?php

use App\Http\Controllers\Api\CVInformationController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


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

