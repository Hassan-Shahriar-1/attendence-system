<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Section;

class SectionPolicy
{

    public function delete(User $user, Section $section): bool
    {
        return $section->students()->count() === 0;
    }
}
