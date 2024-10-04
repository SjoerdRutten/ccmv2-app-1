<?php

namespace Sellvation\CCMV2\Ems\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class EmailContent extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'id',
        'environment_id',
        'user_id',
        'email_category_id',
        'name',
        'description',
        'remarks',
        'start_at',
        'end_at',
        'content',
        'content_type',
        'unpublished_content',
        'unpublished_content_type',
        'updated_at',
    ];

    protected function casts()
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function emailCategory(): BelongsTo
    {
        return $this->belongsTo(EmailCategory::class);
    }
}
