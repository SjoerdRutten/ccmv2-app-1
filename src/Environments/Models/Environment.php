<?php

namespace Sellvation\CCMV2\Environments\Models;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sellvation\CCMV2\CrmCards\Models\CrmCard;
use Sellvation\CCMV2\CrmCards\Models\CrmField;
use Sellvation\CCMV2\CrmCards\Models\CrmFieldCategory;
use Sellvation\CCMV2\Ems\Models\Email;
use Sellvation\CCMV2\Ems\Models\EmailCategory;
use Sellvation\CCMV2\Environments\Scopes\IsActiveScope;
use Sellvation\CCMV2\Orders\Models\Product;
use Sellvation\CCMV2\Users\Models\Customer;

#[ScopedBy([IsActiveScope::class])]
class Environment extends Model
{
    protected $fillable = [
        'id',
        'customer_id',
        'timezone_id',
        'name',
        'description',
        'email_credits',
        'notified',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function environmentFeatures(): HasMany
    {
        return $this->hasMany(EnvironmentFeature::class);
    }

    public function hasFeature($feature): bool
    {
        return $this->environmentFeatures()->where('feature', $feature)->exists();
    }

    public function addFeature($feature): bool
    {
        return (bool) $this->environmentFeatures()->create(['feature' => $feature]);
    }

    public function removeFeature($feature): bool
    {
        return (bool) $this->environmentFeatures()->where('feature', $feature)->delete();
    }
}
