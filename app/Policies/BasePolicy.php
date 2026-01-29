<?php

namespace App\Policies;

use App\Models\User;

abstract class BasePolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
}
