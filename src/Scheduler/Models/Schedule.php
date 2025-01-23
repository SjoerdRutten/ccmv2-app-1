<?php

namespace Sellvation\CCMV2\Scheduler\Models;

use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Scheduler\Enums\ScheduleTaskType;

class Schedule extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
        'description',
        'type',
        'command',
        'arguments',
        'options',
        'pattern',
        'run_on_days',
        'is_active',
        'on_one_server',
        'without_overlapping',
        'ends_after_counter',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'type' => ScheduleTaskType::class,
        'arguments' => 'array',
        'options' => 'array',
        'pattern' => 'array',
        'run_on_days' => 'array',
        'is_active' => 'boolean',
        'on_one_server' => 'boolean',
        'without_overlapping' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}
