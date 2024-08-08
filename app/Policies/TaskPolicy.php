<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function manage(User $user, Task $task): Response
    {
        return $task->user_id === $user->id ? Response::allow() : Response::denyAsNotFound();
    }
}
