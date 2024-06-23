<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Nutgram\Laravel\Middleware\ValidateWebAppData;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebAppIsAuthenticated
{
    public function __construct(private ValidateWebAppData $validateWebAppData)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        return $this->validateAuthentication($request, $next);
    }

    /**
     * Determine if the web app data are provided in the request and valid.
     */
    private function validateAuthentication(Request $request, Closure $next): Response
    {
        if (!$request->filled('initData')) {
            $this->unauthenticated();
        }

        return $this->validateWebAppData->handle($request, $next);
    }

    private function unauthenticated(): void
    {
        abort(403, 'Forbidden.');
    }
}
