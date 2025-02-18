<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'cv_information_id' => $this->cv_information_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'portfolios' => PortfolioResource::collection($this->whenLoaded('portfolios')),
            'cv_information' => new CVInformationResource($this->whenLoaded('cvInformation')),
        ];
    }
} 