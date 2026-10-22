<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        if ($user && $user->isTenant()) {
            if ($user->companies()->count() === 0 && ! $request->routeIs('onboarding.*')) {
                return redirect()->route('onboarding.create');
            }
        }

        return $next($request);
    }
}
