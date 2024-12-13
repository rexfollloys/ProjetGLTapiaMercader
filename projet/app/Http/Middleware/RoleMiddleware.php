<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifie si l'utilisateur est connecté et possède un des rôles spécifiés
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Rediriger l'utilisateur vers le tableau de bord standard (ou page d'accès refusé)
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas la permission d\'accéder à cette page.');
        }

        // Si l'utilisateur a le bon rôle, permettre l'accès
        return $next($request);
    }
}
