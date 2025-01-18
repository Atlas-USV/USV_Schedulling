<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Speciality;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    // Define the table name (if different from the plural form of the model name)
    protected $table = 'evaluations';

    // Mass assignable attributes
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'group_id',
        'room_id',
        'speciality_id',
        //'attempt',
        'exam_date',
        'start_time',
        'end_time',
        'type',
        'other_examinators',
        'description',
        'year_of_study',
        'status',
    ];

    // Cast the other_examinators field to an array (because it's stored as JSON)
    protected $casts = [
        'other_examinators' => 'array',
        'exam_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    // Relationships with other models

    // Subject the evaluation belongs to
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Teacher (User) who is assigned to the evaluation
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Group the evaluation is assigned to
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Room for the evaluation
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Speciality of the evaluation
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
    // Faculty relationship through teacher
    public function faculty()
    {
        return $this->hasOneThrough(
            Faculty::class,
            User::class,
            'id', // Foreign key on users table
            'id', // Foreign key on faculties table
            'teacher_id', // Local key on evaluations table
            'teacher_faculty_id' // Local key on users table
        );
    }

    // Method to check if this is a re-examination
    public function isReexamination()
    {
        return $this->attempt > 1;
    }

    // Method to get the year of study, if applicable (for re-examination)
    public function getYearOfStudyAttribute($value)
    {
        return $value ?? 'N/A'; // Default to 'N/A' if null
    }

    public function otherExaminators()
    {
        return $this->belongsToMany(User::class, 'evaluation_examinator', 'evaluation_id', 'teacher_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
}
