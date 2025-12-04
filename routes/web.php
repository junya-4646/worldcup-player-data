<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/players', [PlayerController::class, 'index']);

Route::get('/players/{id}', function($id) {
    session(['from_list' => true]);
    return redirect("/players/show/$id");
});

Route::get('/players/show/{id}', [PlayerController::class, 'show']);

Route::get('/players/{id}/edit', [PlayerController::class, 'edit']);

Route::post('/plyaers/{id}/delete', [PlayerController::class, 'delete']);

Route::post('/players/{id}/update', [PlayerController::class, 'update']);