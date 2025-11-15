<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'section' => $this->section?->name,
            'grade' => $this->grade?->name,
            'image_url' => $this->image_url,
            'deleted_at' => $this->deleted_at
        ];
    }
}
