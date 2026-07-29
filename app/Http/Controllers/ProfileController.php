<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Muestra el perfil del usuario autenticado.
     */
    public function edit(Request $request): View
    {
        $usuario = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Último recorrido registrado por el usuario
        |--------------------------------------------------------------------------
        |
        | Se carga también la hacienda relacionada para poder mostrarla
        | dentro del resumen de actividad del perfil.
        |
        */

        $ultimoRecorrido = $usuario
            ->recorridos()
            ->with('hacienda')
            ->latest('created_at')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Datos enviados a la vista
        |--------------------------------------------------------------------------
        */

        return view('profile.edit', [
            'user' => $usuario,

            'totalRecorridos' => $usuario
                ->recorridos()
                ->count(),

            'ultimoRecorrido' => $ultimoRecorrido,

            'ultimaHacienda' => $ultimoRecorrido
                ?->hacienda,
        ]);
    }

    /**
     * Actualiza la información del perfil.
     */
    public function update(
        ProfileUpdateRequest $request
    ): RedirectResponse {
        $usuario = $request->user();

        $usuario->fill(
            $request->validated()
        );

        /*
        |--------------------------------------------------------------------------
        | Reiniciar verificación del correo
        |--------------------------------------------------------------------------
        |
        | Si el usuario cambia su correo electrónico, Laravel elimina
        | temporalmente la fecha de verificación.
        |
        */

        if ($usuario->isDirty('email')) {
            $usuario->email_verified_at = null;
        }

        $usuario->save();

        return Redirect::route('profile.edit')
            ->with(
                'status',
                'profile-updated'
            );
    }
}