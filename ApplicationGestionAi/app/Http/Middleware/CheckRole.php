<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();
        
        // Vérifier le rôle
        if ($user->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('home')->with('error', 'Accès refusé. Vous devez être administrateur.');
            } else {
                return redirect()->route('home')->with('error', 'Accès refusé.');
            }
        }

        return $next($request);
    }
}
