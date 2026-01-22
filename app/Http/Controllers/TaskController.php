<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::query()->orderBy('created_at', 'desc')->paginate(3);

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
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Task::query()->create($data);

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
}
