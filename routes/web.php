<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login.view');

Route::get('/login', function () {
    return redirect()->route('login.view');
});

Route::get('/home', function () {

    return view('home');
})->name('home')->middleware('auth');

Route::get('/register', [AuthController::class, 'register'])->name('register.view');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'store'])->name('store');

Route::middleware(['auth'])->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit.view');
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create.view');

    Route::get('temp', [AuthController::class, 'temp']);

    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks/{id}/edit', [TaskController::class, 'update'])->name('tasks.edit');
    Route::post('tasks/create', [TaskController::class, 'store'])->name('tasks.create');
    Route::delete('tasks/{id}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
});
