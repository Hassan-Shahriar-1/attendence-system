<?php

namespace App\Services;

use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Events\AttendanceBulkRecorded;

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
            return Attendance::select(
                'student_id',
                'status',
                DB::raw('COUNT(*) AS total')
            )
                ->whereHas('student', fn($q) => $q->where('grade_id', $gradeId))
                ->whereMonth('date', date('m', strtotime($month)))
                ->whereYear('date', date('Y', strtotime($month)))
                ->groupBy('student_id', 'status')
                ->orderBy('student_id')
                ->get()
                ->groupBy('student_id'); // group by student in PHP
        });
    }

    /**
     * Get attendance statistics for a student
     */
    public function getStats(int $studentId)
    {
        return Cache::tags(['attendance'])->remember("attendance_stats_{$studentId}", 3600, function () use ($studentId) {
            return Attendance::where('student_id', $studentId)
                ->selectRaw('status, COUNT(*) AS count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
        });
    }
}
