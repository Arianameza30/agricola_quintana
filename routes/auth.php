<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Rutas para visitantes
|--------------------------------------------------------------------------
|
| Solamente se permite iniciar sesión y recuperar la contraseña.
| El registro público de usuarios está deshabilitado.
|
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Inicio de sesión
    |--------------------------------------------------------------------------
    */

    Route::get(
        'login',
        [AuthenticatedSessionController::class, 'create']
    )
        ->name('login');


    Route::post(
        'login',
        [AuthenticatedSessionController::class, 'store']
    );


    /*
    |--------------------------------------------------------------------------
    | Recuperación de contraseña
    |--------------------------------------------------------------------------
    */

    Route::get(
        'forgot-password',
        [PasswordResetLinkController::class, 'create']
    )
        ->name('password.request');


    Route::post(
        'forgot-password',
        [PasswordResetLinkController::class, 'store']
    )
        ->name('password.email');


    Route::get(
        'reset-password/{token}',
        [NewPasswordController::class, 'create']
    )
        ->name('password.reset');


    Route::post(
        'reset-password',
        [NewPasswordController::class, 'store']
    )
        ->name('password.store');

});


/*
|--------------------------------------------------------------------------
| Rutas para usuarios autenticados
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Verificación de correo
    |--------------------------------------------------------------------------
    */

    Route::get(
        'verify-email',
        EmailVerificationPromptController::class
    )
        ->name('verification.notice');


    Route::get(
        'verify-email/{id}/{hash}',
        VerifyEmailController::class
    )
        ->middleware([
            'signed',
            'throttle:6,1',
        ])
        ->name('verification.verify');


    Route::post(
        'email/verification-notification',
        [EmailVerificationNotificationController::class, 'store']
    )
        ->middleware('throttle:6,1')
        ->name('verification.send');


    /*
    |--------------------------------------------------------------------------
    | Confirmación y actualización de contraseña
    |--------------------------------------------------------------------------
    */

    Route::get(
        'confirm-password',
        [ConfirmablePasswordController::class, 'show']
    )
        ->name('password.confirm');


    Route::post(
        'confirm-password',
        [ConfirmablePasswordController::class, 'store']
    );


    Route::put(
        'password',
        [PasswordController::class, 'update']
    )
        ->name('password.update');


    /*
    |--------------------------------------------------------------------------
    | Cerrar sesión
    |--------------------------------------------------------------------------
    */

    Route::post(
        'logout',
        [AuthenticatedSessionController::class, 'destroy']
    )
        ->name('logout');

});