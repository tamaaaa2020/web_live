<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBasicAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedUser = (string) env('ADMIN_DASH_USER', '');
        $expectedPass = (string) env('ADMIN_DASH_PASS', '');

        if ($expectedUser === '' || $expectedPass === '') {
            abort(403);
        }

        $user = (string) $request->getUser();
        $pass = (string) $request->getPassword();

        if (!hash_equals($expectedUser, $user) || !hash_equals($expectedPass, $pass)) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin Dashboard"',
            ]);
        }

        return $next($request);
    }
}

