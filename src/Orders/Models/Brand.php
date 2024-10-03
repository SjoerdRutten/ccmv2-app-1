<?php

namespace Sellvation\CCMV2\Orders\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Sellvation\CCMV2\Environments\Traits\HasEnvironment;

class Brand extends Model
{
    use HasEnvironment;

    protected $fillable = [
        'name',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
