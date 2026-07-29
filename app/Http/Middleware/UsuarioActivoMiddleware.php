<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsuarioActivoMiddleware
{
    /**
     * Impide que una cuenta desactivada continúe navegando.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $usuario = $request->user();

        if (! $usuario) {
            return redirect()->route('login');
        }

        if (! $usuario->estaActivo()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Su cuenta se encuentra desactivada. Comuníquese con el administrador del sistema.',
                ]);
        }

        return $next($request);
    }
}