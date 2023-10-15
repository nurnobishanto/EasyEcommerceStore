<?php

namespace App\Http\Middleware;

use Closure;

class HttpsRedirectMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if app.ssl is set to 'https' and the request is not secure (HTTP)
        if (config('app.ssl') === 'https' && !$request->secure()) {
            // Redirect to the secure (HTTPS) version of the URL
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
