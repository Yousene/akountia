<?php

namespace App\Http\Middleware;

use Closure;

class CheckPerm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Vérifier d'abord si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur a un rôle défini
        if (!isset(\Auth::user()->role)) {
            return $next($request);
        }

        // Vérifier les permissions
        if (\Auth::user()->role == 1 || \Auth::user()::hasRoute($request->route()->getName())) {
            return $next($request);
        }

        abort(403);
    }
}
