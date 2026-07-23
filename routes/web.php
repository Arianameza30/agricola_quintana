<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RecorridoController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get(
        '/lotes/configurar',
        [LoteController::class, 'configurar']
    )
    ->name('lotes.configurar');

    Route::post(
        '/lotes/guardar-coordenadas',
        [LoteController::class, 'guardarCoordenadas']
    )
    ->name('lotes.guardar-coordenadas');

    Route::resource(
        'haciendas',
        HaciendaController::class
    );

    Route::resource(
        'lotes',
        LoteController::class
    );

    Route::post(
        '/recorridos/abrir',
        [RecorridoController::class, 'abrir']
    )
    ->name('recorridos.abrir');

    Route::post(
        '/recorridos/generar-pdf',
        [RecorridoController::class, 'generarPdf']
    )
    ->name('recorridos.generar-pdf');

    Route::get(
        '/recorridos/pdf/{id}',
        [RecorridoController::class, 'pdf']
    )
    ->name('recorridos.pdf');

    Route::resource(
        'recorridos',
        RecorridoController::class
    );

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )
    ->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )
    ->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )
    ->name('profile.destroy');
});

require __DIR__.'/auth.php';