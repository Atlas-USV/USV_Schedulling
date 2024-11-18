<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obținem datele necesare pentru modal
        $groups = Group::all();
        $faculties = Faculty::all();
        $subjects = Subject::all();
        $teachers = User::role('admin')->get(); // Dacă utilizezi roluri
        $rooms = Room::all();

        return view('dashboard', compact('groups', 'faculties', 'subjects', 'teachers', 'rooms'));
    }
}

