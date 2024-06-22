<?php

use App\Http\Controllers\TelegramWebApp\TaskController;
use App\Http\Middleware\AuthenticateTelegramUser;
use App\Http\Middleware\EnsureWebAppIsAuthenticated;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

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

            Route::patch('/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
            Route::delete('/{task}/uncomplete', [TaskController::class, 'uncomplete'])->name('tasks.uncomplete');
        });
    });

Route::post('nutgram/webhook', fn(Nutgram $bot) => $bot->run())->name('telegram-webhook');
