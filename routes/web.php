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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | HACIENDAS
    |--------------------------------------------------------------------------
    */

    Route::resource('haciendas', HaciendaController::class);


    /*
    |--------------------------------------------------------------------------
    | LOTES
    |--------------------------------------------------------------------------
    */

    Route::resource('lotes', LoteController::class);

    /*
    |--------------------------------------------------------------------------
    | GUARDAR COORDENADAS DE LOTES
    |--------------------------------------------------------------------------
    |
    | IMPORTANTE:
    | Esta ruta debe estar ANTES de cualquier ruta
    | lotes/{lote} que pueda interferir.
    |
    */

    Route::post(
        '/lotes/guardar-coordenadas',
        [LoteController::class, 'guardarCoordenadas']
    )->name('lotes.guardar-coordenadas');


    /*
    |--------------------------------------------------------------------------
    | RECORRIDOS
    |--------------------------------------------------------------------------
    */

    Route::resource('recorridos', RecorridoController::class);


    /*
    |--------------------------------------------------------------------------
    | RUTA PARA ABRIR RECORRIDO
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/recorridos/abrir',
        [RecorridoController::class, 'abrir']
    )->name('recorridos.abrir');


    /*
    |--------------------------------------------------------------------------
    | PDF DE RECORRIDO
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/recorridos/pdf/{id}',
        [RecorridoController::class, 'pdf']
    )->name('recorridos.pdf');


    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

require __DIR__.'/auth.php';