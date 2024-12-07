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
use App\Shared\EvaluationTypes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CalendarController extends Controller
{
    public function load(Request $request){
        
        $user = Auth::user();
        $faculties = Faculty::all();
        $specialities = Speciality::all();
        // if ($user->hasRole('secretary')) {
        //     // Filter users by faculty_id and role 'teacher'
        //     $teachers = User::role('teacher') // Filters users with the 'teacher' role
        //         ->where('teacher_faculty_id', $user->teacher_faculty_id)
        //         ->get();
        //         $groups = Group::with('speciality') // Eager load the speciality relationship
        //         ->whereHas('speciality.faculty', function ($query) use ($user) {
        //             $query->where('id', $user->teacher_faculty_id); // Filter by faculty ID
        //         })->orderBy('speciality_id') // Sort by speciality_id
        //         ->orderBy('study_year')   // Then by study_year
        //         ->get();
                
        // } else {
        //     // Fetch all users or apply other logic for different roles
        //     $teachers = User::role('teacher')->get();
        //     $groups = Group::with('speciality')
        //     ->orderBy('speciality_id') // Sort by speciality_id
        //     ->orderBy('study_year')   // Then by study_year
        //     ->get();
            
        // }
        $teachers = User::role('teacher')->get();
        $groups = Group::with('speciality')->get()->map(function ($group) {
            $group->speciality_short_name = $group->speciality ? $group->speciality->short_name : null;
            return $group;
        });
        //->orderBy('speciality_id') // Sort by speciality_id
        //->orderBy('study_year')   // Then by study_year
        $evaluationTypes = json_encode(EvaluationTypes::getLocalizedArray());
            
        $subjects = Subject::all();
        $rooms = Room::all();
    
        return view('calendar.index', compact('groups', 'faculties', 'specialities', 'teachers', 'subjects', 'rooms', 'evaluationTypes'));
    }

    public function getAllEvents(Request $request)
    {
        try {
            // Fetch evaluations from the database
            $evaluations = \App\Models\Evaluation::with([
                'subject',
                'group:id,name,speciality_id',
                'speciality:id,name',
                'teacher',
                'room:id,name',
            ])->get();
            // Transform evaluations into event format
            $events = $evaluations->map(function ($evaluation) {
                $eventColor = EvaluationTypes::from($evaluation->type)->getColor();
                return [
                    'id' => $evaluation->id,
                    'title' => $evaluation->type . ': ' . $evaluation->subject->name,
                    'start' => $evaluation->start_time,
                    'end' => $evaluation->end_time,
                    'type' => $evaluation->type,
                    'group' => $evaluation->group ?? null,
                    'speciality' => $evaluation->group ? $evaluation->group->speciality : ($evaluation->speciality ?? null),
                    'teacher' => $evaluation->teacher,
                    'faculty_id' => $evaluation->teacher->teacher_faculty_id,
                    'room' => $evaluation->room ?? null,
                    'description' => $evaluation->description,
                    'teacher_id' => $evaluation->teacher_id,
                    'subject' => $evaluation->subject,
                    'color' => $eventColor, // Add color to the event
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
    //    'exam_date' => Carbon::parse($data['start_time'])->format('Y-m-d'),
    try {
        $baseRules = [
            'type' => 'required|in:exam,colloquium,project,reexamination,retake',
            'teacher_id' => 'required|exists:users,id',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'room_id' => 'required|exists:rooms,id',
            'description' => 'nullable|string|max:65533',
            'other_examinators' => 'nullable|array',
            'other_examinators.*' => 'exists:users,id'
        ];
        // Perform base validation
        $validator = Validator::make($request->all(), $baseRules);
          // Add conditional rules based on type
        $this->addConditionalRules($request, $validator);

        $validatedData = $validator->validated();

        // Add 'exam_date' to the validated data
        $validatedData['exam_date'] = Carbon::parse($validatedData['start_time'])->format('Y-m-d');
        if($this->checkForOverlaps($validatedData)){
             return response()->json([
            'message' => 'Eroare de suprapunere',
            'errors' => [
                'schedule' => ['The schedule overlaps with an existing one.']
            ]
        ], 400); // HTTP 400: Bad Request
        }
        $evaluation = \App\Models\Evaluation::create($validatedData);
        // Handle the specific type
        $eventColor = EvaluationTypes::from($evaluation->type)->getColor();
        $evaluationEvent =  [
            'id' => $evaluation->id,
            'title' => $evaluation->type . ': ' . $evaluation->subject->name,
            'start' => $evaluation->start_time,
            'end' => $evaluation->end_time,
            'type' => $evaluation->type,
            'group' => $evaluation->group ?? null,
            'speciality' => $evaluation->group ? $evaluation->group->speciality : ($evaluation->speciality ?? null),
            'teacher' => $evaluation->teacher,
            'faculty_id' => $evaluation->teacher->teacher_faculty_id,
            'room' => $evaluation->room ?? null,
            'description' => $evaluation->description,
            'teacher_id' => $evaluation->teacher_id,
            'subject' => $evaluation->subject,
            'color' => $eventColor, // Add color to the event
        ];

        // Return success response with the created evaluation in event format
        return response()->json([
            'success' => true,
            'message' => 'Evaluation created successfully.',
            'data' => $evaluationEvent,
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Return validation errors
        return response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred.',
            'errors' => [$e->getMessage()],
        ], 500);
    }
}
protected function checkForOverlaps($data): bool{
    return Evaluation::whereYear('exam_date', now()->year)
            ->where(function($query) use ($data){
            $query->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time']);
        })
        ->where(function ($query) use ($data) {
            $query->where('room_id', $data['room_id'])
                  ->orWhere('teacher_id', $data['teacher_id'])
                //   ->orWhere(function ($subQuery) use ($data) {
                      // Case 1: When group_id is null, check specialty_id + year_of_study
                    //   if (empty($data['group_id']) &&  isset($data['speciality_id'], $data['year_of_study'])) {
                    //       $subQuery->whereNull('group_id')
                    //                ->where('speciality_id', $data['speciality_id'])
                    //                ->where('year_of_study', $data['year_of_study']);
                    //   }
                //   })
                  ->orWhere(function ($subQuery) use ($data) {
                      // Case 2: When specialty_id and year_of_study are null, check group_id
                      if (isset($data['group_id'])) {
                          $subQuery->where('group_id', $data['group_id']);
                      }
                  });
        })
        ->exists();
}

protected function addConditionalRules(Request $request, $validator): void
{
    $type = $request->input('type');

    $rules = match ($type) {
        'exam' => [
            'group_id' => 'required|exists:groups,id',
            'subject_id' => 'required|exists:subjects,id',
        ],
        'colloquium' => [
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'required|exists:groups,id',
        ],
        'project' => [
            'group_id' => 'required_without_all:speciality_id,year_of_study|exists:groups,id',
            'subject_id' => 'required|exists:subjects,id',
        ],
        'reexamination' => [
            'subject_id' => 'nullable|exists:subjects,id',
            'speciality_id' => 'nullable|exists:specialities,id|required_with:year_of_study',
            'year_of_study' => 'nullable|integer|min:1|max:6|required_with:speciality_id',
        ],

        'retake' => [
            'subject_id' => 'required|exists:subjects,id',
            // 'group_id' => 'required_without_all:speciality_id,year_of_study|exists:groups,id',
        ],
        default => [],
    };

    $validator->addRules($rules);
}
}
