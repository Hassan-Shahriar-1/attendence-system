<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
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
        return [
            'name'       => $this->faker->name(),
            'student_id' => $this->generateStudentId(),
            'grade_id'   => Grade::inRandomOrder()->first()?->id ?? 1,
            'section_id' => Section::inRandomOrder()->first()?->id ?? 1,
            'image'      => null,
        ];
    }

    public function generateStudentId(): string
    {
        $last = Student::withTrashed()->max('id') + 1;
        return 'S' . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
