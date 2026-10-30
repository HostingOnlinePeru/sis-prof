<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || $user->isSuperAdmin() || $request->routeIs('membership.*')) {
            return $next($request);
        }

        if (! $user->hasActiveMembership()) {
            return redirect()
                ->route('membership.index')
                ->withErrors(['membership' => 'Tu membresía ha vencido. Elige un plan para seguir usando SISPROF.']);
        }

        return $next($request);
    }
}
