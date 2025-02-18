<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Http\Resources\PortfolioResource;
use App\Http\Requests\Portfolio\StoreRequest;
use App\Http\Requests\Portfolio\UpdateRequest;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{

    public function index()
    {
        $portfolios = Portfolio::all();
        return response()->json([
            'data' => PortfolioResource::collection($portfolios)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('portfolio/images', 'public');
        }
        
        $portfolio = Portfolio::create($data);
        
        return response()->json([
            'message' => 'Portfolyo başarıyla oluşturuldu',
            'data' => new PortfolioResource($portfolio)
        ], 201);
    }

    public function show(Portfolio $portfolio)
    {
        return response()->json([
            'data' => new PortfolioResource($portfolio)
        ]);
    }

    public function update(UpdateRequest $request, Portfolio $portfolio)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $data['image'] = $request->file('image')->store('portfolio/images', 'public');
        }
        
        $portfolio->update($data);
        
        return response()->json([
            'message' => 'Portfolyo başarıyla güncellendi',
            'data' => new PortfolioResource($portfolio)
        ]);
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return response()->json([
            'message' => 'Portfolyo başarıyla silindi'
        ]);
    }
} 