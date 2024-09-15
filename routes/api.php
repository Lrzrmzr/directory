<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('contactos', ContactoController::class);
Route::post('buscar-direccion', [ContactoController::class, 'searchForDireccion']);
Route::post('buscar-correo', [ContactoController::class, 'searchForCorreo']);
Route::post('buscar-telefono', [ContactoController::class, 'searchForTelefono']);