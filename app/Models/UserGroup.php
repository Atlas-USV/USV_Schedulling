<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class UserGroup extends Pivot
{
    protected $fillable = ['user_id', 'group_id'];
}
