<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'grade_id' => ['required', 'exists:graders,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'photo' => ['sometimes', 'nullable', 'file', 'mimetypes:jpeg,jpg,png']
        ];
    }
}
