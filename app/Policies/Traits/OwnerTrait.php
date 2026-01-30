<?php

namespace App\Policies\Traits;

use App\Models\Interfaces\Ownerable;
use App\Models\User;

trait OwnerTrait
{
    /**
     * @param User $user
     * @param Ownerable $model
     * @return bool
     */
    protected function owner(User $user, Ownerable $model): bool
    {
        return $user->id == $model->getOwner()->id;
    }
}
