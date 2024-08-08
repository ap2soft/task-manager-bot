<?php

use App\Http\Controllers\TelegramWebApp\TaskController;
use App\Http\Middleware\AuthenticateTelegramUser;
use App\Http\Middleware\EnsureWebAppIsAuthenticated;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::prefix('telegram-web-app')
    // `twa` -> `telegram-web-app`
    ->name('twa.')
    ->middleware(AuthenticateTelegramUser::class)
    ->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

        Route::middleware(EnsureWebAppIsAuthenticated::class)->group(function () {
            Route::post('/', [TaskController::class, 'store'])
                ->middleware(HandlePrecognitiveRequests::class)
                ->name('tasks.store');
        });
            Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
            Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
            Route::get('/{task}', [TaskController::class, 'show'])->name('tasks.show');
            Route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
