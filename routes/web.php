<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;

//Estaciones de servicio 
use App\Http\Controllers\EstacionController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    Route::view('/', 'home')->name('home');
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);

    //ruta cambio de contraseña
    Route::get('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'showChangePasswordForm'])->name('usuarios.showchangepasswordform');

    Route::post('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'updatePassword'])->name('usuarios.cambiar-contrasena');



    //Estaciones de servicio

    Route::resource('estaciones', EstacionController::class);

    Route::get('/estaciones/listar', [EstacionController::class, 'show'])->name('estaciones.listar');
});
