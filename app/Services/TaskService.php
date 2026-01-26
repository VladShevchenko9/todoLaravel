<?php

namespace App\Services;

use App\Models\Task;
use App\Structures\SearchTasksData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService
{
    public function getTasksWithFilters(SearchTasksData $data): LengthAwarePaginator
    {
        $data->description = trim($data->description);
        $query = Task::query()->where('user_id', $data->userId);

        $query->where(function ($q) use ($data) {

            $method = $data->exactMatch ? 'where' : 'orWhere';

            if ($data->description) {
                $q->{$method}('description', 'like', '%'.$data->description.'%');
            }

            if ($data->priority) {
                $q->{$method}('priority', $data->priority);
            }

            if (! is_null($data->status)) {
                $q->{$method}('status', $data->status);
            }
        });

        return $query->latest()->paginate(3);
    }
}
