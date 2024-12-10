<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name'];

    public function specialities(): HasMany
    {
        return $this->hasMany(Speciality::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class, 'teacher_faculty_id');
    }
    
    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(Group::class, Speciality::class);
    }
}
