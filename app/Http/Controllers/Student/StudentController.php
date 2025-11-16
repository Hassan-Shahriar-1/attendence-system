<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Models\Student;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(public StudentService $studentService) {}

    public function index()
    {
        $students = Student::query()
            ->searchByName()
            ->with(['section', 'grade'])
            ->paginate(request('per_page', 10));
        return ApiResponseHelper::successResponse(StudentResource::collection($students), true);
    }

    public function store(CreateStudentRequest $request)
    {
        $validatedData = $request->validated();
        $student = $this->studentService->createStudentData($validatedData);
        return ApiResponseHelper::successResponse(new StudentResource($student));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $updateData = $request->validated();
        $updateStudent = $this->studentService->updateStudentData($student, $updateData);
        return ApiResponseHelper::successResponse(new StudentResource($updateStudent));
    }

    public function show(Student $student)
    {
        return ApiResponseHelper::successResponse(new StudentResource($student));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return ApiResponseHelper::successResponse([], false, 'deleted');
    }

    public function getStudentsByGradeSection($gradeId, $sectionId)
    {
        $students = Student::where('grade_id', $gradeId)
            ->where('section_id', $sectionId)
            ->get();
        return ApiResponseHelper::successResponse(StudentResource::collection($students));
    }
}
