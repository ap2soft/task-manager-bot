<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nutgram\Laravel\Middleware\ValidateWebAppData;
use Symfony\Component\HttpFoundation\Response;

use function Nutgram\Laravel\Support\webAppData;

/**
 * If Telegram Web App data passed, find the user by Telegram User ID (or create one),
 * and authenticate the user.
 * Otherwise, it's a guest.
 */
class AuthenticateTelegramUser
{
    public function __construct(private ValidateWebAppData $validateWebAppData)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->filled('initData')) {
            return $next($request);
        }

        return $this->validateWebAppData->handle($request, function (Request $request) use ($next) {
            Auth::login($this->getUser());

            return $next($request);
        });
    }

    private function getUser(): User
    {
        $userData = webAppData()->user;

        return User::firstOrCreate(['telegram_user_id' => $userData->id], ['name' => $userData->username]);
    }
}
