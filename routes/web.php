<?php

use Illuminate\Support\Facades\Route;

// Ruta para API/version (opcional)
Route::get('/version', function () {
    return response()->json(['Laravel' => app()->version()]);
});

// Ruta para CSRF (necesaria para Sanctum)
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// ÚNICA RUTA PARA VUE - Todas las rutas frontend
Route::get('/{any}', function () {
    return view('app'); // Asegúrate de tener resources/views/app.blade.php
})->where('any', '.*'); // Captura absolutamente todas las rutas