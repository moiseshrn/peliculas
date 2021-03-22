<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Muestra una lista de todas las películas
Route::get('/', [PeliculaController::class, 'index']);

// Muestra una página con información más detallada sobre una película
Route::get('/detalles/{id}', [PeliculaController::class, 'mostrar']);

// Guarda los comentarios hechos por los usuarios
Route::post('/comentario/{id}', [ComentarioController::class, 'guardar']);
