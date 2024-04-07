<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/trash', [TaskController::class, 'trash'])->name('tasks.trash');
    Route::get('/tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('/tasks/{task}/forever', [TaskController::class, 'destroyForever'])->name('tasks.destroyForever');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', function () {return view('profile.admin');})->name('admin');
});



require __DIR__.'/auth.php';
