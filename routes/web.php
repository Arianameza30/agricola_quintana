<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RecorridoController;
use App\Http\Middleware\AdminMiddleware;


/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route(
            'recorridos.index'
        );
    }

    return redirect()->route(
        'login'
    );

});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| Se conserva esta ruta por compatibilidad con Laravel Breeze.
|
*/

Route::get('/dashboard', function () {

    return redirect()->route(
        'recorridos.index'
    );

})
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Rutas para todos los usuarios autenticados
|--------------------------------------------------------------------------
|
| Administradores y usuarios pueden acceder a recorridos y perfil.
|
*/

Route::middleware('auth')->group(function () {


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


/*
|--------------------------------------------------------------------------
| Rutas exclusivas del administrador
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    AdminMiddleware::class,
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Consulta de lotes
    |--------------------------------------------------------------------------
    |
    | Los lotes ya no se crean, editan ni eliminan desde esta aplicación.
    | La información se obtiene desde el sistema corporativo.
    |
    */

    Route::get(
        '/lotes',
        [LoteController::class, 'index']
    )
        ->name('lotes.index');


    /*
    |--------------------------------------------------------------------------
    | Configuración de coordenadas
    |--------------------------------------------------------------------------
    |
    | Esta funcionalidad se conserva porque las coordenadas son información
    | propia del Sistema de Gestión Agrícola.
    |
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
    |
    | Por ahora se mantienen estas rutas hasta completar la siguiente fase
    | de integración con la tabla corporativa "hacienda".
    |
    */

    Route::resource(
        'haciendas',
        HaciendaController::class
    );

});


require __DIR__.'/auth.php';