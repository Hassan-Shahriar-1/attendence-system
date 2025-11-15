<?php

namespace App\Enums\User;

enum UserTypeEnum: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
}
