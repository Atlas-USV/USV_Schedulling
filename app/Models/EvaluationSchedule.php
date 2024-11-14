<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Subgroup;

use App\Models\Evaluation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['evaluation_id', 'exam_date', 'start_time', 'end_time', 'group_id', 'description', 'room_id', 'other_examinators'];

    protected $casts = [
        'other_examinators' => 'array',
    ];

    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Subgroup::class, 'group_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
