<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PortfolioCategoryController;
use App\Http\Controllers\Api\CVInformationController;
use App\Http\Controllers\Api\CVComponentController;


// Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum','ability:admin']); // 127.0.0.1:8000/api/logout

// CV Information routes
Route::get('cv-information', [CVInformationController::class, 'index']);
Route::get('cv-information/get-active', [CVInformationController::class, 'getActive'])->name('cv.information.getActive');
Route::get('cv-information/{cvInformation}', [CVInformationController::class, 'show']);

// Skill routes
Route::get('skills', [SkillController::class, 'index']);
Route::get('skills/{skill}', [SkillController::class, 'show']);

// Experience routes
Route::get('experiences', [ExperienceController::class, 'index']);
Route::get('experiences/{experience}', [ExperienceController::class, 'show']);

// Service routes
Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{service}', [ServiceController::class, 'show']);

// Portfolio routes
Route::get('portfolios', [PortfolioController::class, 'index']);
Route::get('portfolios/{portfolio}', [PortfolioController::class, 'show']);


// Portfolio Category routes
Route::get('portfolio-categories', [PortfolioCategoryController::class, 'index']);
Route::get('portfolio-categories/{portfolioCategory}', [PortfolioCategoryController::class, 'show']);
// Testimonial routes
Route::get('testimonials', [TestimonialController::class, 'index']);
Route::get('testimonials/{testimonial}', [TestimonialController::class, 'show']);

// Contact routes
Route::post('contact', [ContactController::class, 'sendMessage'])
    ->middleware('throttle.contact');

    // Debug rotası
Route::get('test-auth', [PortfolioController::class, 'testAuth'])->middleware('auth:admin');

// Admin routes
Route::middleware(['auth:sanctum','ability:admin'])->group(function () {
    Route::apiResource('cv-information', CVInformationController::class)->except(['index', 'show']);
    Route::apiResource('skills', SkillController::class)->except(['index', 'show']);
    Route::apiResource('experiences', ExperienceController::class)->except(['index', 'show']);
    Route::apiResource('services', ServiceController::class)->except(['index', 'show']);
    Route::apiResource('portfolios', PortfolioController::class)->except(['index', 'show']);
    Route::apiResource('portfolio-categories', PortfolioCategoryController::class)->except(['index', 'show']);
    Route::apiResource('testimonials', TestimonialController::class)->except(['index', 'show']);

    Route::post('cv-information/set-active/{cvInformation}', [CVInformationController::class, 'setActive']);

    // Portfolyo görselleri yönetimi
    Route::post('portfolios/images/{portfolio}', [PortfolioController::class, 'addImages']);
    Route::get('portfolios/images/{portfolio}', [PortfolioController::class, 'getImages']);
    Route::get('portfolios/images/active/{portfolio}', [PortfolioController::class, 'getActiveImages']);
    Route::put('portfolios/images/order/{portfolio}', [PortfolioController::class, 'updateImageOrder']);
    Route::post('portfolios/images/set-main-image/{portfolio}', [PortfolioController::class, 'setMainImage']);
    Route::delete('portfolios/images/delete/{imageId}', [PortfolioController::class, 'deleteImage']);
    Route::post('portfolios/images/toggle-active/{imageId}', [PortfolioController::class, 'toggleActiveStatus']);

    // ------------------------------------CV Bileşenleri İçin Rotalar----------------------------------------------

    Route::prefix('cv/{cv}/components')->group(function () {
        // Tüm bileşenleri getir
        Route::get('/', [CVComponentController::class, 'getAllComponents']);

        // Belirli tipteki bileşenleri getir
        Route::get('{type}', [CVComponentController::class, 'getComponents'])->name('cv.components.getComponents');

        // Belirli bir bileşenin detayını getir
        Route::get('{type}/{id}', [CVComponentController::class, 'getComponentDetail']);

        // Bileşeni CV'ye ekle
        Route::post('{type}', [CVComponentController::class, 'addComponent'])->name('cv.components.addComponent');

        // CV'den bileşen sil
        Route::delete('{type}', [CVComponentController::class, 'removeComponent'])->name('cv.components.removeComponent');

        // CV'den belirli tipteki tüm bileşenleri sil
        Route::delete('{type}/all', [CVComponentController::class, 'removeAllComponents']);

        // Bileşenlerin sırasını değiştir
        Route::put('{type}/order', [CVComponentController::class, 'reorderComponents']);

        // Tek bir bileşenin sırasını güncelle
        Route::put('{type}/order/single', [CVComponentController::class, 'updateComponentOrder']);

        // Bileşenlerin sayısını getir
        Route::get('{type}/count', [CVComponentController::class, 'getComponentCount']);

    });

    // Bir bileşenin atandığı CV'leri getir
    Route::get('{type}/{id}/cv-information', [CVComponentController::class, 'getComponentCVs']);

    // Tüm bileşenlerin atandığı CV'leri getir
    Route::get('{type}/cv-information', [CVComponentController::class, 'getAllTypeComponentsCVs']);
});

