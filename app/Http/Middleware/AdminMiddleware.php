<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Permite el acceso solamente a administradores.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user();

        if (! $usuario) {
            return redirect()->route('login');
        }

        $rol = mb_strtolower(
            trim((string) $usuario->rol)
        );

        if ($rol !== 'admin') {
            abort(
                403,
                'No tienes permiso para acceder a este módulo.'
            );
        }

        return $next($request);
    }
}