<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProyectosController;

Route::get('/', [HomeController::class, 'getHome']);

Route::get('login', function() {
    return view('auth.login');
});

Route::get('logout', function() {
    return 'Logout usuario';
});

Route::get('proyectos', [ProyectosController::class, 'getIndex']);

Route::get('proyectos/show/{id}', [ProyectosController::class, 'getShow'])
    ->where('id', '[0-9]+');

Route::get('proyectos/create', [ProyectosController::class, 'getCreate']);

Route::get('proyectos/edit/{id}', [ProyectosController::class, 'getEdit'])
    ->where('id', '[0-9]+');

Route::get('perfil/{id?}', function($id = null) {
    return $id ? 'Visualizar el currículo de '. $id : 'Visualizar el currículo propio';
})->where('id', '[0-9]*');
