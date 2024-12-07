<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'subject',
        'deadline',
        'is_completed',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relație cu utilizatorii
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
