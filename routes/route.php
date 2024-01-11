<?php

use App\Services\Route;
use App\Middleware\{
	Auth,
	Guest
};

Route::get('home', 'UserController', 'index', [Guest::class]);
Route::get('user/store', 'UserController', 'create', [Guest::class]);
Route::post('user/store', 'UserController', 'store', [Guest::class]);
Route::get('user/edit/{id}', 'UserController', 'edit', [Guest::class]);
Route::put('user/edit/{id}', 'UserController', 'update', [Guest::class]);
Route::delete('user/delete/{id}', 'UserController', 'delete', [Guest::class]);

Route::get('sorteio', 'SorteioController', 'index', [Guest::class]);
