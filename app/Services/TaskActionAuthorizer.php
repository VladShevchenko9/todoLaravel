<?php

namespace App\Services;

use App\Exceptions\UnauthorizedTaskActionException;
use App\Models\Task;
use App\Models\User;

class TaskActionAuthorizer
{
    /**
     * @param string $action
     * @param User $user
     * @param Task|null $task
     * @return void
     * @throws UnauthorizedTaskActionException
     */
    public function authorizeAction(string $action, User $user, ?Task $task = null): void
    {
        if ($task) {
            $authorized = $user->can($action, $task);
        } else {
            $authorized = $user->can($action, Task::class);
        }

        if (!$authorized) {
            throw new UnauthorizedTaskActionException();
        }
    }
}
