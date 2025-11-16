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
}
