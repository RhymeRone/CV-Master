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

// Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// CV Information routes
Route::get('cv-information', [CVInformationController::class, 'index']);
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

// Admin routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cv-information', CVInformationController::class)->except(['index', 'show']);
    Route::apiResource('skills', SkillController::class)->except(['index', 'show']);
    Route::apiResource('experiences', ExperienceController::class)->except(['index', 'show']);
    Route::apiResource('services', ServiceController::class)->except(['index', 'show']);
    Route::apiResource('portfolios', PortfolioController::class)->except(['index', 'show']);
    Route::apiResource('portfolio-categories', PortfolioCategoryController::class)->except(['index', 'show']);
    Route::apiResource('testimonials', TestimonialController::class)->except(['index', 'show']);
});

