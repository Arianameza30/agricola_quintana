<?php

namespace App\Http\Controllers;

use App\Models\Hacienda;
use Illuminate\Http\Request;

class HaciendaController extends Controller
{
    /**
     * Mostrar listado de haciendas.
     */
    public function index()
    {
        $haciendas = Hacienda::all();

        return view('haciendas.index', compact('haciendas'));
    }

    /**
     * Mostrar formulario para crear una hacienda.
     */
    public function create()
    {
        return view('haciendas.create');
    }

    /**
     * Guardar una nueva hacienda.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
        ]);

        Hacienda::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => true,
        ]);

        return redirect()
            ->route('haciendas.index')
            ->with('success', 'Hacienda registrada correctamente.');
    }

    /**
     * Mostrar una hacienda.
     */
    public function show(Hacienda $hacienda)
    {
        return view('haciendas.show', compact('hacienda'));
    }

    /**
     * Mostrar formulario para editar.
     */
    public function edit(Hacienda $hacienda)
    {
        return view('haciendas.edit', compact('hacienda'));
    }

    /**
     * Actualizar una hacienda.
     */
    public function update(Request $request, Hacienda $hacienda)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable',
        ]);

        $hacienda->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()
            ->route('haciendas.index')
            ->with('success', 'Hacienda actualizada correctamente.');
    }

    /**
     * Eliminar una hacienda.
     */
    public function destroy(Hacienda $hacienda)
    {
        $hacienda->delete();

        return redirect()
            ->route('haciendas.index')
            ->with('success', 'Hacienda eliminada correctamente.');
    }
}