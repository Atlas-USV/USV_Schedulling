<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Speciality;
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
    ];

    // Cast the other_examinators field to an array (because it's stored as JSON)
    protected $casts = [
        'other_examinators' => 'array',
        'exam_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

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

    // Get all the other examinators
    public function getOtherExaminatorsAttribute($value)
    {
        return json_decode($value);
    }
}
