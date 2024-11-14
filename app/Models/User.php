<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Faculty;
use App\Models\Subgroup;
use App\Models\Evaluation;
use App\Models\Speciality;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'speciality_id',
        'teacher_faculty_id',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'teacher_faculty_id');
    }

    public function subgroups(): BelongsToMany
    {
        return $this->belongsToMany(Subgroup::class, 'user_subgroups');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'teacher_id');
    }
}
