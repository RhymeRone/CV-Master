<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'company' => $this->company,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'cv_information_id' => $this->cv_information_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'cv_information' => new CVInformationResource($this->whenLoaded('cvInformation')),
        ];
    }
} 