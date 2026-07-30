<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isOrganizer()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Kalau organizer belum di-approve superadmin, arahkan ke halaman menunggu
        if (!$user->organizer || !$user->organizer->is_approved) {
            return redirect()->route('organizer.pending');
        }

        return $next($request);
    }
}