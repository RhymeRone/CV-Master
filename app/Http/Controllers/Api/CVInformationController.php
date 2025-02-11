<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CVInformation\StoreRequest;
use App\Http\Requests\CVInformation\UpdateRequest;
use App\Http\Resources\CVInformationResource;
use App\Models\CVInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class CVInformationController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(CVInformation::class);
    }

    public function index(): JsonResponse
    {
        $cvInformation = CVInformation::latest()->get();
        return response()->json([
            'data' => CVInformationResource::collection($cvInformation)
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cv/images', 'public');
        }
        
        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('cv/files', 'public');
        }
        
        $cvInformation = CVInformation::create($data);
        
        return response()->json([
            'message' => 'CV bilgileri başarıyla oluşturuldu',
            'data' => new CVInformationResource($cvInformation)
        ], 201);
    }

    public function show(CVInformation $cVInformation): JsonResponse
    {
        return response()->json([
            'data' => new CVInformationResource($cVInformation)
        ]);
    }

    public function update(UpdateRequest $request, CVInformation $cVInformation): JsonResponse
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            if ($cVInformation->image) {
                Storage::disk('public')->delete($cVInformation->image);
            }
            $data['image'] = $request->file('image')->store('cv/images', 'public');
        }
        
        if ($request->hasFile('cv_file')) {
            if ($cVInformation->cv_file) {
                Storage::disk('public')->delete($cVInformation->cv_file);
            }
            $data['cv_file'] = $request->file('cv_file')->store('cv/files', 'public');
        }
        
        $cVInformation->update($data);
        
        return response()->json([
            'message' => 'CV bilgileri başarıyla güncellendi',
            'data' => new CVInformationResource($cVInformation)
        ]);
    }

    public function destroy(CVInformation $cVInformation): JsonResponse
    {
        $cVInformation->delete();
        
        return response()->json([
            'message' => 'CV bilgileri başarıyla silindi'
        ]);
    }
}
