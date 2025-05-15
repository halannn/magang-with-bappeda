<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $requiredStatus): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized: No user.');
        }

        if ($user->status !== $requiredStatus) {
            abort(403, 'Unauthorized: Status mismatch.');
        }

        if ($user->status !== 'admin') {
            if (!$user->profile || $user->profile->status_magang !== 'Aktif') {
                return redirect()->route('pendaftaran.profile.create');
            }
        }

        return $next($request);
    }
}
