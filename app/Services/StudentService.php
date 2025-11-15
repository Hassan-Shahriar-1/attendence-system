<?php

namespace App\Services;

use App\Traits\FileUpload;

class StudentService
{
    use FileUpload;

    public function createStudentData(array $validatedData)
    {
        if (isset($validatedData['image']) && $validatedData['image']) {
        }
    }
}
