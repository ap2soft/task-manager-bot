<?php

use App\Http\Controllers\TelegramWebApp\TaskListController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram-web-app')
    // `twa` -> `telegram-web-app`
    ->name('twa.')
    ->group(function () {
        Route::get('/', [TaskListController::class, 'index'])->name('tasks.index');
        Route::middleware(HandlePrecognitiveRequests::class)->group(function () {
            Route::post('/', [TaskListController::class, 'store'])->name('tasks.store');
        });
        Route::patch('/{task}/complete', [TaskListController::class, 'complete'])->name('tasks.complete');
        Route::delete('/{task}/uncomplete', [TaskListController::class, 'uncomplete'])->name('tasks.uncomplete');
    });
