<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $attendance = $this->attendances->first();
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->name,
            'status' => $attendance?->status,
            'note' => $attendance?->note,
            'image_url' => $this->image_url,
        ];
    }
}
