<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'comment' => $this->comment,
            'job' => $this->job,
            'image' => $this->image ? Storage::url($this->image) : null,
            'cv_information_id' => $this->cv_information_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'cv_information' => new CVInformationResource($this->whenLoaded('cvInformation')),
        ];
    }
} 