<?php

namespace App\Rules;

use App\Models\Grade;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GradeNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // This works for API Resource routes:
        $routeParam = request()->route('grade');

        // When using route model binding, $routeParam is a Section model
        $currentId = is_object($routeParam) ? $routeParam->id : $routeParam;

        $exists = Grade::where('name', $value)
            ->when($currentId, fn($q) => $q->where('id', '!=', $currentId))
            ->exists();

        if ($exists) {
            $fail("The section name '{$value}' is already taken.");
        }
    }
}
