<?php

namespace App\Models;

use App\Models\User;
use App\Models\Faculty;

use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'speciality_id', 'study_year', 'number'];

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_group', 'group_id', 'user_id')
                    ->withTimestamps();
    }
    
    public function faculty(): BelongsTo
    {
        return $this->belongsToThrough(Faculty::class, Speciality::class);
    }
    
}
