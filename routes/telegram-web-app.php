<?php

use App\Http\Controllers\TelegramWebApp\TaskListController;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram-web-app')->group(function () {
    Route::get('/', [TaskListController::class, 'index']);
});
