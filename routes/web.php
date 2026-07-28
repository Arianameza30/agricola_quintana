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
        return redirect()->route('recorridos.index');
    }

    return redirect()->route('login');

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

    return redirect()->route('recorridos.index');

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
| Administradores y usuarios finales pueden acceder a recorridos y perfil.
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
|
| Se utiliza directamente AdminMiddleware::class para evitar problemas
| con el alias "admin".
|
*/

Route::middleware([
    'auth',
    AdminMiddleware::class,
])->group(function () {


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

});


require __DIR__.'/auth.php';