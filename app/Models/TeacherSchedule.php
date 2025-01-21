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

class TeacherSchedule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];
}
