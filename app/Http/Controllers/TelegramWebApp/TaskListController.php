<?php

namespace App\Http\Controllers\TelegramWebApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramWebApp\TaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TaskListController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('TelegramWebApp/Tasks/TaskList', [
            'tasks' => Task::query()
                // order by status: incomplete, then complete
                // order by creation date: oldest first
                ->orderByRaw(
                    <<<'SQL'
                      case complete
                        when 1 then 999
                        else 0
                      end
                    SQL
                    ,
                )
                ->oldest()
                ->paginate(10)
                ->through(fn(Task $task) => $task->only(['id', 'text', 'complete'])),
        ]);
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return redirect()->route('twa.tasks.index');
    }

    public function complete(Task $task): RedirectResponse
    {
        $task->update(['complete' => true]);

        return redirect()->route('twa.tasks.index');
    }

    public function uncomplete(Task $task): RedirectResponse
    {
        $task->update(['complete' => false]);

        return redirect()->route('twa.tasks.index');
    }
}
