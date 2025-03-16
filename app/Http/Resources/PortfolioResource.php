<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'link' => $this->link,
            // Ana görseli URL olarak döndür
            'main_image' => $this->main_image_path ? Storage::url($this->main_image_path) : null,
            
            // Tüm görselleri dizi olarak döndür
            'images' => $this->images->map(function($image) {
                return [
                    'id' => $image->id,
                    'image_url' => Storage::url($image->image_path),
                    'is_main' => $image->is_main,
                    'sort_order' => $image->sort_order
                ];
            }),

            'categories' => $this->categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'icon' => $category->icon,
                    'slug' => $category->slug
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
} 