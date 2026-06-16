<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPeserta
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isPeserta()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh peserta.');
        }

        return $next($request);
    }
}