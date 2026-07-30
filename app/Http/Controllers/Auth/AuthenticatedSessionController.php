<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar la pantalla de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar el inicio de sesión.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validar formulario
        |--------------------------------------------------------------------------
        */

        $datos = $request->validate(
            [
                'usuario' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'usuario.required' => 'Debes ingresar tu usuario.',
                'usuario.string' => 'El usuario ingresado no es válido.',
                'usuario.max' => 'El usuario no puede superar los 100 caracteres.',

                'password.required' => 'Debes ingresar tu contraseña.',
                'password.string' => 'La contraseña ingresada no es válida.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Preparar credenciales
        |--------------------------------------------------------------------------
        */

        $credenciales = [
            'usuario' => trim($datos['usuario']),
            'password' => $datos['password'],
            'activo' => 1,
        ];

        /*
        |--------------------------------------------------------------------------
        | Intentar autenticación
        |--------------------------------------------------------------------------
        */

        $autenticado = Auth::guard('web')->attempt(
            $credenciales,
            $request->boolean('remember')
        );

        Log::info('Intento de inicio de sesión', [
            'usuario' => $credenciales['usuario'],
            'autenticado' => $autenticado,
            'session_id_antes' => $request->session()->getId(),
        ]);

        if (! $autenticado) {
            throw ValidationException::withMessages([
                'usuario' => 'El usuario o la contraseña son incorrectos.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerar sesión
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        Log::info('Inicio de sesión exitoso', [
            'user_id' => Auth::id(),
            'usuario' => Auth::user()?->usuario,
            'rol' => Auth::user()?->rol,
            'session_id_despues' => $request->session()->getId(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirección directa
        |--------------------------------------------------------------------------
        |
        | No utilizamos redirect()->intended() para evitar que una URL antigua
        | almacenada en la sesión devuelva al usuario nuevamente al login.
        |
        */

        return redirect()->route('recorridos.index');
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}