<?php

namespace App\Http\Controllers\TelegramWebApp;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class TaskListController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('TelegramWebApp/Tasks/TaskList', [
            'tasks' => [],
        ]);
    }
}
