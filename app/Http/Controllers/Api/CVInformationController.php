<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CVInformation\StoreRequest;
use App\Http\Requests\CVInformation\UpdateRequest;
use App\Http\Resources\CVInformationResource;
use App\Models\CVInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CVInformationController extends Controller
{

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

    public function show(CVInformation $cvInformation): JsonResponse
    {
        return response()->json([
            'data' => new CVInformationResource($cvInformation)
        ]);
    }

    public function update(UpdateRequest $request, CVInformation $cvInformation): JsonResponse
    {
        Log::info($request->all());
        $data = $request->validated();
        Log::info($data);

        if ($request->hasFile('image')) {
            if ($cvInformation->image) {
                Storage::disk('public')->delete($cvInformation->image);
            }
            $data['image'] = $request->file('image')->store('cv/images', 'public');
        }

        if ($request->hasFile('cv_file')) {
            if ($cvInformation->cv_file) {
                Storage::disk('public')->delete($cvInformation->cv_file);
            }
            $data['cv_file'] = $request->file('cv_file')->store('cv/files', 'public');
        }

        $cvInformation->update($data);

        return response()->json([
            'message' => 'CV bilgileri başarıyla güncellendi',
            'data' => new CVInformationResource($cvInformation->fresh())
        ]);
    }

    public function destroy(CVInformation $cvInformation): JsonResponse
    {
        if ($cvInformation->image) {
            Storage::disk('public')->delete($cvInformation->image);
        }

        if ($cvInformation->cv_file) {
            Storage::disk('public')->delete($cvInformation->cv_file);
        }

        $cvInformation->delete();

        return response()->json([
            'message' => 'CV bilgileri başarıyla silindi'
        ]);
    }

    public function setActive(Request $request): JsonResponse
    {
        // Önce tüm CV'leri pasif yap
        CVInformation::where('is_active', true)->update(['is_active' => false]);

        $cvInformation = CVInformation::findOrFail($request->cv_id);
        $cvInformation->is_active = true;
        $cvInformation->save();

        return response()->json([
            'success' => true,
            'message' => 'CV başarıyla aktifleştirildi',
            'data' => new CVInformationResource($cvInformation)
        ]);
    }
}
