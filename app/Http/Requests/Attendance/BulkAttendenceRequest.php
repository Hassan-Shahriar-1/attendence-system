<?php

namespace App\Http\Requests\Attendance;

use App\Enums\Attendance\AttendanceStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BulkAttendenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['required', 'exists:students,id'],
            'status'        => ['required', new Enum(AttendanceStatusEnum::class)],
            'date'          => ['required', 'date_format:Y-m-d'],
            'note'          => ['nullable', 'string']
        ];
    }
}
