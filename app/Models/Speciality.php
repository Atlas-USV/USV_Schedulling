<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name', 'faculty_id'];

    public function teacher_faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'specialty_id');
    }
}
