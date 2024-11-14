<?php

namespace App\Models;

use App\Models\User;
use App\Models\Subject;

use App\Models\EvaluationSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = ['subject_id', 'teacher_id', 'type'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function evaluationSchedules(): HasMany
    {
        return $this->hasMany(EvaluationSchedule::class);
    }
}
