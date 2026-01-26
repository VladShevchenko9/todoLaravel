<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Structures\SearchTasksData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request, TaskService $taskService)
    {
        $userId = (int) auth()->id();

        $validator = Validator::make($request->query(), [
            'description' => 'string|min:5|max:255|nullable',
            'priority' => 'integer|min:1|max:5|nullable',
            'status' => 'boolean|nullable',
            'exactMatch' => 'boolean|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('tasks.index')
                ->with('error', 'Invalid search parameters.');
        }

        $searchData = new SearchTasksData($userId);
        $searchData->description = $request->query('description', '');
        $searchData->priority = $request->query('priority', 0);
        $searchData->status = $request->query('status');
        $searchData->exactMatch = (bool) $request->query('exactMatch', true);

        $tasks = $taskService->getTasksWithFilters($searchData);

        return view('tasks', compact('tasks'));
    }

    public function update(UpdateTaskRequest $request, int $id): RedirectResponse
    {
        $task = Task::query()->find($id);

        if (! $task) {
            return redirect()
                ->route('tasks.index')
                ->with('error', 'Task not found!');
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $task->update($data);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function store(CreateTaskRequest $request): RedirectResponse
    {
        Task::query()->create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task added successfully!');
    }

    public function edit(int $id): RedirectResponse|View
    {
        $task = Task::query()->find($id);

        if (! $task) {
            return redirect()
                ->route('tasks.index')
                ->with('error', 'Task not found!');
        }

        return view('editTask', compact('task'));
    }

    public function create(): View
    {
        return view('createTask');
    }

    public function delete(int $id): RedirectResponse|View
    {
        $deletedTotal = Task::query()->where('id', $id)->delete();

        if (! $deletedTotal) {
            return redirect()
                ->route('tasks.index')
                ->with('error', 'Task not found!');
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}
