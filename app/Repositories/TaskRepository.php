<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends AbstractRepository
{
    /** @var class-string<Task> */
    protected string $modelClass = Task::class;
}
