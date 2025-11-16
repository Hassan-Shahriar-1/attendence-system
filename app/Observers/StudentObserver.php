<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        //
    }

    public function creating(Student $student): void
    {
        if (!$student->student_id) {
            $student->student_id = $this->generateStudentId();
        }
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }

    public function generateStudentId()
    {
        // Get the last student ID
        $lastStudent = Student::orderBy('id', 'desc')->first();

        if (!$lastStudent || !$lastStudent->student_id) {
            return 'S001';
        }

        $number = (int) str_replace('S', '', $lastStudent->student_id);
        $number++;

        // Format with leading zeros
        return 'S' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
