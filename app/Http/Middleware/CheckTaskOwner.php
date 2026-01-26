<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaskOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $taskId = $request->route('id');
        $task = Task::find($taskId);

        if ($task && $task->user_id !== auth()->id()) {
            return redirect()
                ->route('tasks.index')
                ->with('error', 'You are not allowed to modify this task!');
        }

        return $next($request);
    }
}
