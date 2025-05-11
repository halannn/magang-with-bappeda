<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $status): Response
    {
        $user = $request->user();

        if (!$user || $user->status !== $status) {
            abort(403, 'Unauthorized access.');
        }

        if (!$user->profile || $user->profile->status_magang !== 'aktif') {
            return redirect()->route('pendaftaran.profile.create');
        }

        return $next($request);
    }
}
