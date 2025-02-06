<?php

namespace Sellvation\CCMV2\CrmCards\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CrmCardMongoQueryBuilder extends Builder
{
    public function tokenIntersolve($tokenIntersolve): self
    {
        return $this->where('token_intersolve', (string) $tokenIntersolve);
    }
}
