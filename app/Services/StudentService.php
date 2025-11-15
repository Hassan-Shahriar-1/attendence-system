<?php

namespace App\Services;

use App\Models\Student;
use App\Traits\FileUpload;

class StudentService
{
    use FileUpload;

    public function createStudentData(array $validatedData)
    {
        if (isset($validatedData['photo']) && $validatedData['photo']) {
            $validatedData['image'] = $this->uploadOne($validatedData['photo'], 'student', config('filesystems.default'));
        }
        $validatedData['student_id'] = $this->generateStudentId();

        return Student::create($validatedData);
    }

    public function updateStudentData(Student $student, array $updateData)
    {
        if (isset($updateData['photo']) && $updateData['photo']) {
            $this->deleteOne($student->image, config('filesystems.default'));
            $updateData['image'] = $this->uploadOne($updateData['photo'], 'student', config('filesystems.default'));
        }
        $student->update($updateData);
        return $student->refresh();
    }

    protected function generateStudentId()
    {
        // Get the last student ID
        $lastStudent = Student::orderBy('id', 'desc')->first();

        if (!$lastStudent || !$lastStudent->student_id) {
            return 'S001';
        }

        $number = (int) str_replace('S', '', $lastStudent->student_id);
        $number++;

        // Format with leading zeros
        return 'S' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
