<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Structures\SearchTasksData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class TaskService
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function getTasksWithFilters(SearchTasksData $data): LengthAwarePaginator
    {
        $data->description = trim($data->description);

        $filters = ['user_id' => $data->userId];
        $optionalFilters = [];
        $searchPartials = [];
        $optionalSearchPartials = [];

        if ($data->description) {
            $optionalSearchPartials['description'] = $data->description;
        }

        if ($data->priority) {
            $optionalFilters['priority'] = $data->priority;
        }

        if (! is_null($data->status)) {
            $optionalFilters['status'] = $data->status;
        }

        if ($data->exactMatch) {
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
