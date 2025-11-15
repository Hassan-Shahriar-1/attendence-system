<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->with(['section', 'grade'])
            ->paginate(request('per_page', 10));
        return ApiResponseHelper::successResponse(StudentResource::collection($students), true);
    }

    public function store(CreateStudentRequest $request)
    {
        $validatedData = $request->validated();
    }
    public function update() {}
    public function show(Student $student) {}
    public function destroy(Student $student)
    {
        $student->delete();
        return ApiResponseHelper::successResponse([], false, 'deleted');
    }
}
