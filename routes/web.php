<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// @todo: Use middleware.
Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('tasks/{id}/edit', [TaskController::class, 'update'])->name('tasks.edit');

require __DIR__ . '/settings.php';
