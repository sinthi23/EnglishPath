<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileCompletedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->profile_completed_at) {
            return $next($request);
        }

        return redirect()
            ->route('profile.edit')
            ->with('error', 'Complete your profile first, then you can open the protected pages.');
    }
}
