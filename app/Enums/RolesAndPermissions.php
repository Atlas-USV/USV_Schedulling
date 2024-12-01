<?php

namespace App\Enums;

enum EPermission: string
{
    case VIEW_EXAMS = 'view_exams';
    case CREATE_EXAMS = 'create_exams';
    case EDIT_EXAMS = 'edit_exams';
    case DELETE_EXAMS = 'delete_exams';
    case MANAGE_USERS = 'manage_users';
}

enum ERole: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case SECRETARY = 'secretary';
}