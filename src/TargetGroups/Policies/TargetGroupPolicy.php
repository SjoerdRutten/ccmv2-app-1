<?php

namespace Sellvation\CCMV2\TargetGroups\Policies;

use Sellvation\CCMV2\TargetGroups\Models\TargetGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TargetGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, TargetGroup $targetGroup): bool {}

    public function create(User $user): bool {}

    public function update(User $user, TargetGroup $targetGroup): bool {}

    public function delete(User $user, TargetGroup $targetGroup): bool {}

    public function restore(User $user, TargetGroup $targetGroup): bool {}

    public function forceDelete(User $user, TargetGroup $targetGroup): bool {}
}
