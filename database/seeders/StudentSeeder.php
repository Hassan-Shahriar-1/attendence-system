<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student::factory()->count(200)->create([]);
        $total = 200;
        for ($i = 1; $i <= $total; $i++) {
            Student::factory()->create();
        }
    }
}
