<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Policies\Traits\OwnerTrait;

class TaskPolicy extends BasePolicy
{
    use OwnerTrait;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $this->owner($user, $task);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $this->owner($user, $task);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $this->owner($user, $task);
    }
}
