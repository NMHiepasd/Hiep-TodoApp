<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

// REVIEW: refactor
// Thừa code khi dùng với Route::resource()
Route::get('/edit-task', function () {
    return view('Tasks.edit');
});


// REVIEW: refactor
// Thừa code khi dùng với Route::resource()
Route::get('/task', [TaskController::class, 'index']);

Route::resource('/tasks', TaskController::class);

// REVIEW: missing method
// Không có method updateStatus
Route::get('/tasks/{task}/updateStatus', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');


Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('email/verify', [VerificationController::class, 'verify']);
Route::post('email/resend', [VerificationController::class, 'resend']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);
Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
