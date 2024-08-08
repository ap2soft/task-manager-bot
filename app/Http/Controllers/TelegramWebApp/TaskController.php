<?php

namespace App\Http\Controllers\TelegramWebApp;

use App\Http\Controllers\Controller;
use App\Http\Repositories\TaskRepository;
use App\Http\Requests\TelegramWebApp\TaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller implements HasMiddleware
{
    public function __construct(private readonly TaskRepository $repository)
    {
    }

    public static function middleware(): array
    {
        return [new Middleware(HandlePrecognitiveRequests::class, only: ['store'])];
    }

    public function index(): Response
    {
        return Inertia::render('TelegramWebApp/Tasks/Index', [
            'tasks' => Inertia::lazy(fn() => $this->repository->getUserTasks(Auth::user())),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('TelegramWebApp/Tasks/Create');
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $this->repository->create($request->user(), $request->validated());

        return redirect()->route('twa.tasks.index');
    }

    public function show(Task $task): Response
    {
        Gate::authorize('manage', $task);

        return Inertia::render('TelegramWebApp/Tasks/Show', [
            'task' => $task,
        ]);
    }

    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('manage', $task);

        $task->delete();

        return redirect()->route('twa.tasks.index');
    }
}
