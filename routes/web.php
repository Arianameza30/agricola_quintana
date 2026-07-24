<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RecorridoController;


/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('recorridos.index');
    }

    return redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| Se conserva esta ruta por compatibilidad con Laravel Breeze, pero ahora
| redirige directamente al módulo principal de Recorridos.
|
*/

Route::get('/dashboard', function () {

    return redirect()->route('recorridos.index');

})
->middleware([
    'auth',
    'verified',
])
->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Configuración de coordenadas
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Haciendas
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'haciendas',
        HaciendaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Lotes
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'lotes',
        LoteController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Recorridos
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

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