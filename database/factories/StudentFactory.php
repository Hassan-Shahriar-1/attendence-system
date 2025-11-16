<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Section;
use App\Services\StudentService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $studentService = new StudentService;
        return [
            'name'       => $this->faker->name(),
            'grade_id'   => Grade::inRandomOrder()->first()?->id ?? 1,
            'section_id' => Section::inRandomOrder()->first()?->id ?? 1,
            'image'      => null,
        ];
    }
}
