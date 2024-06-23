<?php

namespace App\Http\Controllers\TelegramWebApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramWebApp\TaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        $userTasks = $user
            ?->tasks()
            // order by status: incomplete, then complete
            // order by creation date: oldest first
            ->orderByRaw(
                <<<'SQL'
                  case
                    when complete = 1 then 999
                    else 0
                  end
                SQL
                ,
            )
            ->oldest()
            ->paginate(10)
            ->through(fn(Task $task) => $task->only(['id', 'text', 'complete']));

        return Inertia::render('TelegramWebApp/Tasks/TaskList', [
            'tasks' => $userTasks,
        ]);
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        logger('store task', ['data' => $request->validated()]);
        Auth::user()->tasks()->create($request->validated());

        return redirect()->route('twa.tasks.index');
    }

    public function complete(Task $task): RedirectResponse
    {
        Gate::authorize('manage', $task);

        $task->update(['complete' => true]);

        return redirect()->route('twa.tasks.index');
    }

    public function uncomplete(Task $task): RedirectResponse
    {
        Gate::authorize('manage', $task);

        $task->update(['complete' => false]);

        return redirect()->route('twa.tasks.index');
    }
}
