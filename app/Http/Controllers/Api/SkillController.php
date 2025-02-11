<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Http\Resources\SkillResource;
use App\Http\Requests\Skill\StoreRequest;
use App\Http\Requests\Skill\UpdateRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SkillController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Skill::class);
    }

    public function index()
    {
        $skills = Skill::all();
        return response()->json([
            'data' => SkillResource::collection($skills)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $skill = Skill::create($request->validated());
        return response()->json([
            'message' => 'Yetenek başarıyla oluşturuldu',
            'data' => new SkillResource($skill)
        ], 201);
    }

    public function show(Skill $skill)
    {
        return response()->json([
            'data' => new SkillResource($skill)
        ]);
    }

    public function update(UpdateRequest $request, Skill $skill)
    {
        $skill->update($request->validated());
        return response()->json([
            'message' => 'Yetenek başarıyla güncellendi',
            'data' => new SkillResource($skill)
        ]);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json([
            'message' => 'Yetenek başarıyla silindi'
        ]);
    }
} 