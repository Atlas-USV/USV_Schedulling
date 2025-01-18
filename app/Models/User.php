<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Group;
use App\Shared\ERoles;
use App\Models\Faculty;
use App\Models\Evaluation;
use App\Models\Speciality;
use App\Models\Message;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Notifications\CustomEmailVerificationNotification;

/**
 * @method bool save() Salvează modelul în baza de date.
 */


class User extends Authenticatable implements MustVerifyEmail
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
        'background_color', 
        'avatar',     // Adaugă și avatar dacă vrei să îl salvezi
        'year_of_start',
        
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

    public function evaluationsAsStudent()
{
    return $this->hasManyThrough(
        Evaluation::class,
        UserGroup::class,
        'user_id',     // Foreign key on UserGroup table
        'group_id',    // Foreign key on Evaluation table
        'id',          // Local key on User table
        'group_id'     // Local key on UserGroup table
    );
}

    public function evaluationsAsTeacher()
{
    return $this->hasMany(Evaluation::class, 'teacher_id', 'id');
}

public function evaluations()
{
    if ($this->hasRole('student')) {
        return $this->evaluationsAsStudent();
    } elseif ($this->hasRole('teacher')) {
        return $this->evaluationsAsTeacher();
    }
    return null; // Or handle admin/other roles as needed
}

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    public function faculty()
    {
        if ($this->hasRole(ERoles::STUDENT)) {
            return $this->hasOneThrough(Faculty::class, Speciality::class, 'id', 'id', 'speciality_id', 'faculty_id');
        }
        return $this->belongsTo(Faculty::class, 'teacher_faculty_id');
    }
    // public function getFacultyAttribute(): ?Faculty
    // {
    //     return $this->getFaculty();
    // }
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id')
                    ->withTimestamps()
                    ->withTimestamps()
                ->select('groups.id');
    }

    // public function evaluations(): HasMany
    // {
    //     return $this->hasMany(Evaluation::class, 'teacher_id');
    // }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomEmailVerificationNotification());
    }

    public function getYearOfStudy()
    {
        $evaluation = $this->evaluationsAsStudent()->first(); // Obține prima evaluare a studentului
        return $evaluation ? $evaluation->year_of_study : 'N/A'; // Returnează anul de studiu sau 'N/A'
    }

    public function getYearsOfWork()
    {
        if (!$this->year_of_start) 
        {
            return 'N/A';
        }
        return now()->year - $this->year_of_start;
    }




    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
