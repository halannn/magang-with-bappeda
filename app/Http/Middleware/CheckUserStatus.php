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
            return redirect()->route('home');
        }

        if ($user->status !== $requiredStatus) {
            abort(403, 'Unauthorized: Status mismatch.');
        }

        if ($user->status !== 'admin') {
            if (!$user->profile) {
                return redirect()->route('pendaftaran.profile.create');
            }

            $statusMagang = $user->profile->status_magang;

            if ($statusMagang === 'Dikeluarkan') {
                abort(403, 'Anda Resmi Dikeluarkan dari magang.');
            }

            if ($statusMagang === 'Pending') {
                return redirect()->route('pendaftaran.profile.create');
            }
        }

        return $next($request);
    }
}
