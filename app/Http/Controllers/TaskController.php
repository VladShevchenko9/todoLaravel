<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::query()->orderBy('created_at', 'desc')->paginate(20);

        return view('tasks.index', compact('tasks'));
    }

    public function update(UpdateTaskRequest $request, int $id)
    {
        // @todo: Do a proper redirection or display a message.
        $task = Task::query()->findOrFail($id);
        $task->user_id = auth()->id();
        $task->description = $request->taskDescription;
        $task->priority = $request->taskPriority;
        $task->status = $request->taskStatus;
        $task->save();

        return redirect()
            ->back()
            ->with('success', 'Task updated successfully!');
    }
}
