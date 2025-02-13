<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use App\Http\Resources\PortfolioCategoryResource;
use App\Http\Requests\PortfolioCategory\StoreRequest;
use App\Http\Requests\PortfolioCategory\UpdateRequest;

class PortfolioCategoryController extends Controller
{

    public function index()
    {
        $categories = PortfolioCategory::with('portfolios')->get();
        return response()->json([
            'data' => PortfolioCategoryResource::collection($categories)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $category = PortfolioCategory::create($request->validated());
        
        return response()->json([
            'message' => 'Kategori başarıyla oluşturuldu',
            'data' => new PortfolioCategoryResource($category)
        ], 201);
    }

    public function show(PortfolioCategory $portfolioCategory)
    {
        return response()->json([
            'data' => new PortfolioCategoryResource($portfolioCategory->load('portfolios'))
        ]);
    }

    public function update(UpdateRequest $request, PortfolioCategory $portfolioCategory)
    {
        $portfolioCategory->update($request->validated());
        
        return response()->json([
            'message' => 'Kategori başarıyla güncellendi',
            'data' => new PortfolioCategoryResource($portfolioCategory)
        ]);
    }

    public function destroy(PortfolioCategory $portfolioCategory)
    {
        $portfolioCategory->delete();
        return response()->json([
            'message' => 'Kategori başarıyla silindi'
        ]);
    }
} 