<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Group;
use App\Shared\ERoles;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Evaluation;
use App\Models\Speciality;
use App\Shared\EPermissions;
use Illuminate\Http\Request;
use App\Shared\EvaluationTypes;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CalendarController extends Controller
{
    
    public function load(Request $request){
        
        $faculties = Faculty::all();
        $specialities = Speciality::all();
       
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

        $user = null;
        $canProposeExam = false;
        
        if (Auth::check()) {
            $user = Auth::user()->load(['speciality']);
            $canProposeExam = auth()->user()->hasRole(ERoles::STUDENT->value) && 
                             auth()->user()->can(EPermissions::PROPOSE_EXAM->value);
        }

        return view('calendar.index', compact('groups', 'faculties', 'specialities', 'teachers', 
                   'subjects', 'rooms', 'evaluationTypes','canProposeExam', 'user'));
    }

    public function getAllEvents(Request $request)
    {
        try {
            // Enable query logging
            \DB::enableQueryLog();

            // Fetch evaluations from the database
            $evaluations = \App\Models\Evaluation::with([
                'subject',
                'group:id,name,speciality_id',
                'speciality:id,name', 
                'teacher:id,name,teacher_faculty_id',
                'room:id,name',
                'teacher.faculty:id,name' // Add eager loading for faculty relationship
            ])
            ->where('status', 'accepted')
            ->get();

            // Log the executed query
            $queries = \DB::getQueryLog();
            \Log::info('Executed queries:', $queries);

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
                    'color' => $eventColor,
                    'faculty' => $evaluation->teacher->faculty// Now efficiently loaded
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
    public function propose(Request $request) {
        // Authorization check for creating an Evaluation
        Gate::authorize('propose', Evaluation::class);
    
        // Validation rules
        $baseRules = [
            'type' => 'required|in:exam,colloquium,project',
            'teacher_id' => 'required|exists:users,id',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'subject_id' => 'required|exists:subjects,id'
        ];
        $validatedData = $request->validate($baseRules);
        $validatedData['exam_date'] = Carbon::parse($validatedData['start_time'])->format('Y-m-d');
        
        // Check if user has a group
        $groupId = Auth::user()->groups ? Auth::user()->groups->first()->id : null;
        if (is_null($groupId)) {
            return response()->json([
                'success' => false,
                'message' => 'Eroare de validare',
                'errors' => [
                    'group_id' => ['Studentul nu este intr-o grupa']
                ]
            ], 422);
        }
        
        $validatedData['group_id'] = $groupId;
        
        // Check for overlap with the group's exam date
        $overlapCheck = $this->checkForOverlaps($validatedData);
        if ($overlapCheck['hasOverlap']) {
            return response()->json([
                'message' => 'Eroare de suprapunere',
                'errors' => [
                    'schedule' => [$overlapCheck['message']]
                ]
            ], 400);
        }
        
        $evaluation = \App\Models\Evaluation::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Exam proposal is sent.',
            'data' => $evaluation,
        ], 201);
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

        // Check if teacher and group are from same faculty
        $teacher = \App\Models\User::find($validatedData['teacher_id']);
        $group = \App\Models\Group::find($validatedData['group_id']);
        
        if ($group && $teacher) {
            $groupFacultyId = $group->speciality->faculty_id;
            $teacherFacultyId = $teacher->teacher_faculty_id;
            
            if ($groupFacultyId !== $teacherFacultyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => [
                        'teacher_id' => ['Cadrul didactic trebuie să fie din aceeași facultate cu grupa']
                    ]
                ], 422);
            }
        }

        $overlapCheck = $this->checkForOverlaps($validatedData);
        if ($overlapCheck['hasOverlap']) {
            return response()->json([
                'message' => 'Eroare de suprapunere',
                'errors' => [
                    'schedule' => [$overlapCheck['message']]
                ]
            ], 400);
        }
        $validatedData['status'] = 'accepted';
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
protected function checkForOverlaps($data): array {
    $examYear = Carbon::parse($data['exam_date'])->year;
    
    if (in_array($data['type'], [EvaluationTypes::EXAM->value, EvaluationTypes::COLLOQUIUM->value, EvaluationTypes::PROJECT->value])) {
        // Check 1: If group already has this subject scheduled
        $existingSubjectEvaluation = Evaluation::whereYear('exam_date', $examYear)
            ->where('group_id', $data['group_id'])
            ->where('subject_id', $data['subject_id'])
            ->first();

        \Log::info('Checking for existing subject evaluation', [
            'year' => $examYear,
            'group_id' => $data['group_id'],
            'subject_id' => $data['subject_id'],
            'found' => !is_null($existingSubjectEvaluation)
        ]);

        if ($existingSubjectEvaluation) {
            return [
                'hasOverlap' => true,
                'message' => 'Această grupă are deja programat un examen la această materie în acest an.'
            ];
        }

        // Check 2: Time conflicts for group
        $groupConflict = Evaluation::whereYear('exam_date', $examYear)
            ->where('group_id', $data['group_id'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->first();

        if ($groupConflict) {
            return [
                'hasOverlap' => true,
                'message' => 'Această grupă are deja programat un alt examen în acest interval orar.'
            ];
        }

        // Check 3: Time conflicts for teacher
        $teacherConflict = Evaluation::whereYear('exam_date', $examYear)
            ->where('teacher_id', $data['teacher_id'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->first();

        if ($teacherConflict) {
            return [
                'hasOverlap' => true,
                'message' => 'Profesorul selectat are deja programat un alt examen în acest interval orar.'
            ];
        }

        // Check 4: Time conflicts for room (if room is specified)
        if (isset($data['room_id'])) {
            $roomConflict = Evaluation::whereYear('exam_date', $examYear)
                ->where('room_id', $data['room_id'])
                ->where('start_time', '<', $data['end_time'])
                ->where('end_time', '>', $data['start_time'])
                ->first();

            if ($roomConflict) {
                return [
                    'hasOverlap' => true,
                    'message' => 'Sala selectată este deja ocupată în acest interval orar.'
                ];
            }
        }
    } else {
        // For retakes and reexaminations, only check teacher and room conflicts
        
        // Check 1: Time conflicts for teacher
        $teacherConflict = Evaluation::whereYear('exam_date', $examYear)
            ->where('teacher_id', $data['teacher_id'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->first();

        if ($teacherConflict) {
            return [
                'hasOverlap' => true,
                'message' => 'Profesorul selectat are deja programat un alt examen în acest interval orar.'
            ];
        }

        // Check 2: Time conflicts for room (if room is specified)
        if (isset($data['room_id'])) {
            $roomConflict = Evaluation::whereYear('exam_date', $examYear)
                ->where('room_id', $data['room_id'])
                ->where('start_time', '<', $data['end_time'])
                ->where('end_time', '>', $data['start_time'])
                ->first();

            if ($roomConflict) {
                return [
                    'hasOverlap' => true,
                    'message' => 'Sala selectată este deja ocupată în acest interval orar.'
                ];
            }
        }
    }
    
    return ['hasOverlap' => false, 'message' => ''];
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
