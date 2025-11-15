<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GradeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::all()->pluck('id')->toArray();

        if (empty($sections)) {
            $this->command->info('No sections found. Please seed sections first.');
            return;
        }

        Grade::all()->each(function ($grade) use ($sections) {
            // Pick 3 random section IDs
            $randomSections = collect($sections)->random(min(3, count($sections)))->toArray();
            // Attach to pivot table
            $grade->sections()->sync($randomSections);
        });

        $this->command->info('Random sections assigned to all grades successfully.');
    }
}
