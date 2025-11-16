<?php

namespace App\Http\Requests\Attendance;

use App\Enums\Attendance\AttendanceStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BulkAttendenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d'],
            'records' => ['required', 'array'],
            'records.*.student_id' => ['required', 'exists:students,id'],
            'records.*.status' => ['required', new Enum(AttendanceStatusEnum::class)],
            'records.*.note' => ['nullable', 'string'],
        ];
    }
}
