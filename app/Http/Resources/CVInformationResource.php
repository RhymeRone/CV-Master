<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CVInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slogan' => $this->slogan ? explode(',', $this->slogan) : [],
            'birthday' => $this->birthday,
            'degree' => $this->degree,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'experience' => $this->experience,
            'freelance' => $this->freelance,
            'clients' => $this->clients,
            'projects' => $this->projects,
            'social_media' => [
                'linkedin' => $this->linkedin,
                'github' => $this->github,
                'twitter' => $this->twitter,
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'website' => $this->website,
            ],
            'image' => $this->image ? Storage::url($this->image) : null,
            'cv_file' => $this->cv_file ? Storage::url($this->cv_file) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
