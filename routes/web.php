<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    // Route::get('/', function () {
        // return view('home');
    // });
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados');
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias');

    Route::post('/empleados/empleado/add', [EmpleadoController::class, 'add'])->name('empleado.add');
    Route::post('/empleados/empleado/update', [EmpleadoController::class, 'update'])->name('empleado.update');
    Route::post('/empleados/empleado/{id}/disabled', [EmpleadoController::class, 'disabled'])->name('empleado.disabled');
    Route::post('/empleados/empleado/{id}/enabled', [EmpleadoController::class, 'enabled'])->name('empleado.enabled');
});

Route::get('/registro', [AsistenciaController::class, 'registro'])->name('registro');
Route::post('/registrar-asistencia', [AsistenciaController::class, 'registrarAsistencia'])->name('registrar-asistencia');