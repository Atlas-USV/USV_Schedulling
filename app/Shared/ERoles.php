<?php

namespace App\Shared;


enum ERoles: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case SECRETARY = 'secretary';
}