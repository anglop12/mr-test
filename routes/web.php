<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', [UserController::class, 'index']);
// Esto no es error, solo renombre las rutas
// Route::get('index-medium', [UserController::class, 'index_medium']);
// Route::get('index-fast', [UserController::class, 'index_fast']);
Route::get('index-fast-relacional', [UserController::class, 'index_fast_relacional']);
Route::get('index-fast-polimorfica', [UserController::class, 'index_fast_polimorfica']);
