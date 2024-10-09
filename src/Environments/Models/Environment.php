<?php

namespace Sellvation\CCMV2\Environments\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailCategory;

class Environment extends Model
{
    protected $fillable = [
        'id',
        'team_id',
        'timezone_id',
        'name',
        'description',
        'email_credits',
        'notified',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }

    public function crmFieldCategories(): HasMany
    {
        return $this->hasMany(CrmFieldCategory::class);
    }

    public function crmFields(): HasMany
    {
        return $this->hasmany(CrmField::class);
    }

    public function crmCards(): HasMany
    {
        return $this->hasMany(CrmCard::class);
    }

    public function emailCategories(): HasMany
    {
        return $this->hasMany(EmailCategory::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }
}
