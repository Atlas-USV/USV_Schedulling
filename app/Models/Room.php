<?php

namespace App\Models;

use App\Models\EvaluationSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'block', 'short_name'];

    public function evaluationSchedules(): HasMany
    {
        return $this->hasMany(EvaluationSchedule::class);
    }
}
