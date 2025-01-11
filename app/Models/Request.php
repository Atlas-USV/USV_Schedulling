<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id', // Profesorul destinat
        'student_id', // Studentul care trimite cererea
        'content',    // Conținutul cererii
        'status',     // Statusul cererii (e.g., pending, approved, denied)
        'created_at', // Data la care a fost trimisă cererea
    ];

    // Relația cu profesorul
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relația cu studentul
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
