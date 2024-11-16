<?php

namespace App\Models;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Grouproup;
use App\Models\Speciality;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'role_id',
        'created_by',
        'speciality_id',
        'group_id',
        'teacher_faculty_id',
        'expires_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
