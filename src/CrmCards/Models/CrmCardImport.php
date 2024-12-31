<?php

namespace Sellvation\CCMV2\CrmCards\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;
use Sellvation\CCMV2\Users\Traits\HasUser;

class CrmCardImport extends Model
{
    use HasEnvironment;
    use HasUser;

    protected $fillable = [
        'path',
        'file_name',
        'fields',
        'number_of_rows',
        'quantity_updated_rows',
        'updated_rows',
        'quantity_created_rows',
        'created_rows',
        'quantity_empty_rows',
        'empty_rows',
        'quantity_error_rows',
        'error_rows',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'fields' => 'json',
        'updated_rows' => 'json',
        'created_rows' => 'json',
        'empty_rows' => 'json',
        'error_rows' => 'json',
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->started_at) {
                    return 0;
                } elseif (! $this->finished_at) {
                    return 1;
                } else {
                    return 2;
                }
            }
        );
    }
}
