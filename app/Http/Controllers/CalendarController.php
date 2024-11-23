<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Evaluation;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function load(Request $request){
        
        
        $groups = Group::all();
        $faculties = Faculty::all();
        $specialities = Speciality::all();
        $teachers = User::role('admin')->get(); // Assuming you use roles
        $subjects = Subject::all();
        $rooms = Room::all();
    
        return view('calendar.index', compact('groups', 'faculties', 'specialities', 'teachers', 'subjects', 'rooms'));
    }

    public function getAllEvents(Request $request)
    {
        Log::info('Request events: ', ['request' =>$request]);
        try {
            // Fetch evaluations from the database
            $evaluations = \App\Models\Evaluation::all();

            // Transform evaluations into event format
            $events = $evaluations->map(function ($evaluation) {
                return [
                    'id' => $evaluation->id,
                    'title' => $evaluation->type . ': ' . $evaluation->subject->name,
                    'start' => $evaluation->start_time,
                    'end' => $evaluation->end_time,
                    'type' => $evaluation->type,
                    'group' => $evaluation->group->name ?? null,
                    'speciality' => $evaluation->speciality->name,
                    'teacher' => $evaluation->teacher->name,
                    'room' => $evaluation->room->name ?? null,
                    'description' => $evaluation->description,
                ];
            });

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Events fetched successfully.',
                'data' => $events,
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching events.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create(Request $request)
    {
       // Log::info('Request: ', ['request' =>$request->all()]);
    try {
        // Validation
        $validatedData = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'group_id' => 'nullable|exists:groups,id',
            'room_id' => 'nullable|exists:rooms,id',
            'speciality_id' => 'required|exists:specialities,id',
            'start_time' => 'required|date||before:end_time',
            'end_time' => 'required|date|after:start_time',
            'type' => 'required|in:exam,colloquium,project,reexamination,retake',
            'other_examinators' => 'nullable|array',
            'other_examinators.*' => 'exists:users,id', // Validate each examiner
            'description' => 'nullable|string|max:500',
            'year_of_study' => 'nullable|integer|min:1|max:6',
        ]);
        // Create the evaluation
        $evaluation = \App\Models\Evaluation::create($this->handleTypeSpecificFields($validatedData));

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

protected function handleTypeSpecificFields(array $data): array
{
    // Define common fields
    $fields = [
        'subject_id' => $data['subject_id'],
        'teacher_id' => $data['teacher_id'],
        'group_id' => $data['group_id'] ?? null,
        'room_id' => $data['room_id'] ?? null,
        'start_time' => $data['start_time'],
        'end_time' => $data['end_time'],
        'type' => $data['type'],
        'other_examinators' => $data['other_examinators'] ?? null,
        'description' => $data['description'] ?? null,
        'year_of_study' => $data['year_of_study'] ?? null,
    ];

    // Add type-specific fields if needed
    switch ($data['type']) {
        case 'exam':
        case 'colloquium':
        case 'project':
        case 'reexamination':
        case 'retake':
            $fields['speciality_id'] = $data['speciality_id'];
            break;
        default:
            throw new \Exception("Invalid type provided");
    }

    // Extract exam_date from start_time
    $fields['exam_date'] = Carbon::parse($fields['start_time'])->format('Y-m-d');

    return $fields;
}
}
