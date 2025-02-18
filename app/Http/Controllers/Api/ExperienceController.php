<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Http\Resources\ExperienceResource;
use App\Http\Requests\Experience\StoreRequest;
use App\Http\Requests\Experience\UpdateRequest;

class ExperienceController extends Controller
{

    public function index()
    {
        $experiences = Experience::all();
        return response()->json([
            'data' => ExperienceResource::collection($experiences)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $experience = Experience::create($request->validated());
        return response()->json([
            'message' => 'Deneyim başarıyla oluşturuldu',
            'data' => new ExperienceResource($experience)
        ], 201);
    }

    public function show(Experience $experience)
    {
        return response()->json([
            'data' => new ExperienceResource($experience)
        ]);
    }

    public function update(UpdateRequest $request, Experience $experience)
    {
        $experience->update($request->validated());
        return response()->json([
            'message' => 'Deneyim başarıyla güncellendi',
            'data' => new ExperienceResource($experience)
        ]);
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return response()->json([
            'message' => 'Deneyim başarıyla silindi'
        ]);
    }
} 