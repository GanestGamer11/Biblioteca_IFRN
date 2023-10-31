<?php

use App\Http\Controllers\LivrosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('livros', [LivrosController::class, 'index']);
Route::post('livros', [LivrosController::class, 'store']);
Route::get('livros/{id}', [LivrosController::class, 'show']);
Route::put('livros/{id}', [LivrosController::class, 'update']);
Route::delete('livros/{id}', [LivrosController::class, 'destroy']);


