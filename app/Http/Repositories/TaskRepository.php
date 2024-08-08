<?php

namespace App\Http\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function getUserTasks(?User $user): ?LengthAwarePaginator
    {
        return $user
            ?->tasks()
            ->where('date', '>=', now())
            ->oldest('date')
            ->paginate(10)
            ->through(fn(Task $task) => $task->only(['id', 'title', 'date', 'notify_at']));
    }

    public function create(User $user, array $data): Task
    {
        return $user->tasks()->create([...$data, 'date' => "{$data['date']} {$data['time']}"]);
    }
}
