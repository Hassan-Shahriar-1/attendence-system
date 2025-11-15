<?php

namespace App\Enums\Attendance;

enum AttendanceStatusEnum: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LATE = 'late';
}
