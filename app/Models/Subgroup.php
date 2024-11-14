<?php

namespace App\Models;

use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subgroup extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'speciality_id', 'study_year', 'index'];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subgroups');
    }

    public function evaluationSchedules(): HasMany
    {
        return $this->hasMany(EvaluationSchedule::class, 'group_id');
    }
}
