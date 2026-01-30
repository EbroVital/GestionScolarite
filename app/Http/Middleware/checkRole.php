<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // recupère le role de l'utilisateur connecté et authentifié
        $userRole = auth()->user()->role;

        // verifie si le role de l'utilisateur authentifié correspond à ceux disponible dans le tableau $roles sinon on a un 403
        if(!in_array($userRole, $roles)){
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
