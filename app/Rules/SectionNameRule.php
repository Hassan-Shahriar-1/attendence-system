<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Section;

class SectionNameRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // This works for API Resource routes:
        $routeParam = request()->route('section');

        // When using route model binding, $routeParam is a Section model
        $currentId = is_object($routeParam) ? $routeParam->id : $routeParam;

        $exists = Section::where('name', $value)
            ->when($currentId, fn($q) => $q->where('id', '!=', $currentId))
            ->exists();

        if ($exists) {
            $fail("The section name '{$value}' is already taken.");
        }
    }
}
