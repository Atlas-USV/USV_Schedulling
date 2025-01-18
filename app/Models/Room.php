<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'block', 'short_name'];

    public static function validationRules(): array
{
    return [
        'name' => 'nullable|string|max:255',
        'block' => 'nullable|string|max:50',
        'short_name' => 'nullable|string|max:50',
    ];
}


    
}
