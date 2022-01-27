<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskLog extends Model
{
    use HasFactory;

    public $fillable = [
        'result',
        'type',
        'execution_interval',
        'action_count',
        'success_count',
        'failed_count',
        'task_id',
        'message'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
