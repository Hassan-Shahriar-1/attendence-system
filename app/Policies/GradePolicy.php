<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;

class GradePolicy
{
    public function delete(Grade $grade)
    {
        return $grade->students()->count() === 0;
    }
}
