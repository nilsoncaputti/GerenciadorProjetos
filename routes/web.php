<?php

use App\Http\Controllers\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InativarFuncionario;

Route::get('/', Home::class)->name('index');

Route::resource('clients', ClientController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('projects', ProjectController::class);

Route::get('employees/{employee}/inativar', InativarFuncionario::class)->name('employees.inativar');
