<?php

namespace App\Policies\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait OwnerTrait
{
    /**
     * @param User $user
     * @param Model $model
     * @return bool
     */
    protected function owner(User $user, Model $model): bool
    {
        return property_exists($model, 'user_id') && $user->id == $model->user_id;
    }
}
