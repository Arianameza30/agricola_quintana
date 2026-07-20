<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Hacienda;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index()
{
    $lotes = Lote::with('hacienda')->get();

    return view('lotes.index', compact('lotes'));
}

    public function create()
    {
        $haciendas = Hacienda::all();

        return view('lotes.create', compact('haciendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hacienda_id' => 'required|exists:haciendas,id',
            'nombre' => 'required|max:100',
            'has_prod' => 'required|numeric',
        ]);

        Lote::create([
            'hacienda_id' => $request->hacienda_id,
            'nombre' => $request->nombre,
            'has_prod' => $request->has_prod,
            'estado' => true,
        ]);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote registrado correctamente.');
    }

    public function show(Lote $lote)
    {
        //
    }

    public function edit(Lote $lote)
    {
        $haciendas = Hacienda::all();

        return view('lotes.edit', compact('lote', 'haciendas'));
    }

    public function update(Request $request, Lote $lote)
    {
        $request->validate([
            'hacienda_id' => 'required|exists:haciendas,id',
            'nombre' => 'required|max:100',
            'has_prod' => 'required|numeric',
        ]);

        $lote->update([
            'hacienda_id' => $request->hacienda_id,
            'nombre' => $request->nombre,
            'has_prod' => $request->has_prod,
        ]);

        return redirect()->route('lotes.index')
            ->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}