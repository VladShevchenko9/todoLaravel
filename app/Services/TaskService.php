<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TaskRepository;
use App\Structures\SearchTasksData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class TaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function getTasksWithFilters(SearchTasksData $data): LengthAwarePaginator
    {

        $filters = ['user_id' => $data->getUser()->id];
        $optionalFilters = [];
        $searchPartials = [];
        $optionalSearchPartials = [];

        if ($data->getUser()->isAdmin()) {
            $filters = [];
        }

        if ($data->getDescription()) {
            $optionalSearchPartials['description'] = $data->getDescription();
        }

        if ($data->getPriority()) {
            $optionalFilters['priority'] = $data->getPriority();
        }

        if (!is_null($data->getStatus())) {
            $optionalFilters['status'] = $data->getStatus();
        }

        if ($data->getExactMatch()) {
            $filters += $optionalFilters;
            $optionalFilters = [];
            $searchPartials = $optionalSearchPartials;
            $optionalSearchPartials = [];
        }

        return $this->taskRepository->paginateWithFilters(
            $filters,
            $optionalFilters,
            $searchPartials,
            $optionalSearchPartials
        );
    }
}
