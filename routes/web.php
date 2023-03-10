<?php

use App\Http\Controllers\MarcaController;
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

    $marcas = DB::table('marcas')->get();

    return view('welcome', ['marcas' => $marcas]);
});


Route::get('/marcas', [MarcaController::class, 'index']);
Route::get('/marca/create', [MarcaController::class, 'create']);
Route::post('/marca/store', [MarcaController::class, 'store']);
Route::get('/marca/edit/{id}', [MarcaController::class, 'edit']);
Route::put('/marca/update', [MarcaController::class, 'update']);
Route::get('/marca/confirm/{id}/{mkNombre}', [MarcaController::class, 'confirm']);
Route::delete('/marca/destroy', [MarcaController::class, 'destroy']);
