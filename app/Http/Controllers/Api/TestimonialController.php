<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Http\Resources\TestimonialResource;
use App\Http\Requests\Testimonial\StoreRequest;
use App\Http\Requests\Testimonial\UpdateRequest;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return response()->json([
            'data' => TestimonialResource::collection($testimonials)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonial/images', 'public');
        }
        
        $testimonial = Testimonial::create($data);
        
        return response()->json([
            'message' => 'Referans başarıyla oluşturuldu',
            'data' => new TestimonialResource($testimonial)
        ], 201);
    }

    public function show(Testimonial $testimonial)
    {
        return response()->json([
            'data' => new TestimonialResource($testimonial)
        ]);
    }

    public function update(UpdateRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();
        
        if ($request->hasFile('image')) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('testimonial/images', 'public');
        }
        
        $testimonial->update($data);
        
        return response()->json([
            'message' => 'Referans başarıyla güncellendi',
            'data' => new TestimonialResource($testimonial)
        ]);
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response()->json([
            'message' => 'Referans başarıyla silindi'
        ]);
    }
} 