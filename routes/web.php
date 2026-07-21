<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HaciendaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\RecorridoController;


/*
|--------------------------------------------------------------------------
| INICIO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | HACIENDAS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'haciendas',
        HaciendaController::class
    );


    /*
    |--------------------------------------------------------------------------
    | LOTES
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'lotes',
        LoteController::class
    );


    /*
    |--------------------------------------------------------------------------
    | GUARDAR COORDENADAS
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/lotes/guardar-coordenadas',
        [
            LoteController::class,
            'guardarCoordenadas'
        ]
    )
    ->name(
        'lotes.guardar-coordenadas'
    );


    /*
    |--------------------------------------------------------------------------
    | RECORRIDOS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'recorridos',
        RecorridoController::class
    );


    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [
            ProfileController::class,
            'edit'
        ]
    )
    ->name('profile.edit');


    Route::patch(
        '/profile',
        [
            ProfileController::class,
            'update'
        ]
    )
    ->name('profile.update');


    Route::delete(
        '/profile',
        [
            ProfileController::class,
            'destroy'
        ]
    )
    ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';