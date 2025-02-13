<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\Service\StoreRequest;
use App\Http\Requests\Service\UpdateRequest;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json([
            'data' => ServiceResource::collection($services)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $service = Service::create($request->validated());
        return response()->json([
            'message' => 'Hizmet başarıyla oluşturuldu',
            'data' => new ServiceResource($service)
        ], 201);
    }

    public function show(Service $service)
    {
        return response()->json([
            'data' => new ServiceResource($service)
        ]);
    }

    public function update(UpdateRequest $request, Service $service)
    {
        $service->update($request->validated());
        return response()->json([
            'message' => 'Hizmet başarıyla güncellendi',
            'data' => new ServiceResource($service)
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Hizmet başarıyla silindi'
        ]);
    }
} 