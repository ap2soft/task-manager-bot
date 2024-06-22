<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Nutgram\Laravel\Middleware\ValidateWebAppData;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebAppIsAuthenticated
{
    public function __construct(private ValidateWebAppData $validateWebAppData)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->validateAuthentication($request, $next);

        return $next($request);
    }

    /**
     * Determine if the web app data are provided in the request and valid.
     *
     * @throws UnauthorizedException
     */
    private function validateAuthentication(Request $request, Closure $next): void
    {
        if (!$request->filled('initData')) {
            $this->unauthenticated();
        }

        $this->validateWebAppData->handle($request, $next);
    }

    /**
     * @throws UnauthorizedException
     */
    private function unauthenticated(): void
    {
        throw new UnauthorizedException('Unauthorized.');
    }
}
