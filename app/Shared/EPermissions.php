<?php

namespace App\Shared;


enum EPermissions: string
{
    case VIEW_EXAMS = 'view_exams';
    case CREATE_EXAMS = 'create_exams';
    case EDIT_EXAMS = 'edit_exams';
    case DELETE_EXAMS = 'delete_exams';
    case MANAGE_USERS = 'manage_users';
    case PROPOSE_EXAM = 'propose_exam';

    case VIEW_USERS = "view_users";
    case EDIT_DELETE_USER = "edit_delete_users";
}