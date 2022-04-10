<?php

namespace App\Models;

use App\Traits\CreatingUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    use CreatingUuid;

    public const MAX_SLEEP_TIME = 20;

    public $fillable = [
        'name',
        'account_id',
        'type',
        'execution_interval',
        'keyword',
        'start_time_period',
        'end_time_period',
        'max_execution',
        'range_min_sleep_time',
        'range_max_sleep_time',
        'is_enable',
    ];

    protected $casts = [
        'account_id' => 'integer',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function taskLogs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }
}
