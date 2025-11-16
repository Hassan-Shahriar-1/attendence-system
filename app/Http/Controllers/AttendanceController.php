<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\Attendance\BulkAttendenceRequest;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct(public AttendanceService $attendanceService) {}

    public function bulkAttendance(BulkAttendenceRequest $request)
    {
        $attendanceData = $request->validated();

        $this->attendanceService->recordBulk($attendanceData, Auth::id());
        return ApiResponseHelper::successResponse([], false, 'completed');
    }

    public function getMonthlyAttendanceReport(Request $request)
    {
        $request->validate([
            'month' => ['required', 'date_format:Y-m'], // YYYY-MM
            'grade_id' => ['required', 'exists:grades,id']
        ]);
        $report = $this->attendanceService->getMonthlyReport($request->grade_id, $request->month);
        return ApiResponseHelper::successResponse($report);
    }

    public function getTodayAttendanceReport()
    {
        $todayReport = $this->attendanceService->dateWiseReport(today());
        return ApiResponseHelper::successResponse($todayReport);
    }
}
