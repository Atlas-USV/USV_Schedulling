<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Evaluation;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function load(){
        $groups = Group::all();
        $faculties = Faculty::all();
        $specialities = Speciality::all();
        $teachers = User::role('admin')->get(); // Assuming you use roles
        $subjects = Subject::all();
        $rooms = Room::all();
    
        return view('calendar.index', compact('groups', 'faculties', 'specialities', 'teachers', 'subjects', 'rooms'));
    }

    public function create(Request $request)
{
    try {
        // Validation
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'room_id' => 'nullable|exists:rooms,id',
            'speciality_id' => 'required|exists:specialities,id',
            'exam_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:Y-m-d H:i:s|before:end_time',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'type' => 'required|in:exam,colloquium,project,reexamination,retake',
            'other_examinators' => 'nullable|array',
            'other_examinators.*' => 'exists:users,id', // Validate each examiner
            'description' => 'nullable|string|max:500',
            'year_of_study' => 'nullable|integer|min:1|max:6',
        ]);

        // Create the evaluation
        $evaluation = \App\Models\Evaluation::create([
            'subject_id' => $validatedData['subject_id'],
            'teacher_id' => $validatedData['teacher_id'],
            'group_id' => $validatedData['group_id'],
            'room_id' => $validatedData['room_id'],
            'speciality_id' => $validatedData['speciality_id'],
            'exam_date' => $validatedData['exam_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'type' => $validatedData['type'],
            'other_examinators' => $validatedData['other_examinators'] ?? null,
            'description' => $validatedData['description'],
            'year_of_study' => $validatedData['year_of_study'],
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Evaluation created successfully.',
            'data' => $evaluation,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Return validation errors
        return response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Return server error
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
