<?php

namespace App\Services;

use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Events\AttendanceBulkRecorded;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class AttendanceService
{
    /**
     * Bulk record attendance (PostgreSQL optimized)
     */
    public function recordBulk(array $attendanceData, int $recordedBy)
    {
        if (empty($attendanceData)) {
            return;
        }

        // Chunk to avoid memory issues
        collect($attendanceData['student_ids'])->chunk(500)->each(function ($chunk) use ($recordedBy, $attendanceData) {
            $records = $chunk->map(fn($studentID) => [
                'student_id' => $studentID,
                'date' => $attendanceData['date'],
                'status' => $attendanceData['status'],
                'note' => $attendanceData['note'] ?? null,
                'recorded_by' => $recordedBy,
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            // PostgreSQL UPSERT using Eloquent
            Attendance::upsert(
                $records,
                ['student_id', 'date'], // unique keys
                ['status', 'note', 'recorded_by', 'updated_at']
            );
        });
    }

    /**
     * Get monthly report for a grade
     * Aggregated in SQL to reduce PHP processing
     */
    public function getMonthlyReport(int $gradeId, string $month)
    {
        $cacheKey = "attendance_report_{$gradeId}_{$month}";

        return Cache::tags(['attendance'])->remember($cacheKey, 3600, function () use ($gradeId, $month) {

            $year = date('Y', strtotime($month));
            $monthNum = date('m', strtotime($month));

            $students = Student::with(['attendances' => fn($q) => $q->whereYear('date', $year)->whereMonth('date', $monthNum)])
                ->where('grade_id', $gradeId)
                ->get();

            $monthlyData = $students->map(function ($student) {
                $present = $student->attendances->where('status', 'present')->count();
                $absent  = $student->attendances->where('status', 'absent')->count();
                $late    = $student->attendances->where('status', 'late')->count();

                return [
                    'student_id' => $student->id,
                    'name'       => $student->name,
                    'class'      => $student->class,
                    'section'    => $student->section,
                    'present'    => $present,
                    'absent'     => $absent,
                    'late'       => $late,
                ];
            });

            $totals = [
                'present' => $monthlyData->sum('present'),
                'absent'  => $monthlyData->sum('absent'),
                'late'    => $monthlyData->sum('late'),
            ];

            return [
                'monthlyData' => $monthlyData,
                'totals'      => $totals
            ];
        });
    }


    public function dateWiseReport(string $date)
    {
        $totalStudents = Student::count();

        $attendanceStats = Attendance::selectRaw("
            COUNT(*) FILTER (WHERE status = 'present' OR status = 'late') AS present_count,
            COUNT(*) FILTER (WHERE status = 'late') AS late_count,
            COUNT(*) FILTER (WHERE status = 'absent') AS absent_count
        ")
            ->whereDate('date', $date)
            ->first();

        $presentCount = $attendanceStats->present_count ?? 0; // includes late
        $lateCount = $attendanceStats->late_count ?? 0;
        $absentCount = $attendanceStats->absent_count ?? 0;

        return [
            'date' => $date,
            'total_students' => $totalStudents,
            'present' => [
                'count' => $presentCount,
                'percentage' => $totalStudents ? round($presentCount / $totalStudents * 100, 2) : 0
            ],
            'late' => [
                'count' => $lateCount,
                'percentage' => $totalStudents ? round($lateCount / $totalStudents * 100, 2) : 0
            ],
            'absent' => [
                'count' => $absentCount,
                'percentage' => $totalStudents ? round($absentCount / $totalStudents * 100, 2) : 0
            ],
        ];
    }
}
