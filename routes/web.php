<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([
    'verify' => true
]);

Route::get('/email/verify', '\App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', '\App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify')->middleware(['signed']);
Route::post('/email/resend', '\App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/userlist', [App\Http\Controllers\admin\UserController::class, 'userlist'])->name('userlist');
Route::get('/task_list', [App\Http\Controllers\admin\TaskController::class, 'task_list'])->name('task_list');
Route::get('/task_add', [App\Http\Controllers\admin\TaskController::class, 'task_add'])->name('task_add');
Route::post('/task_save', [App\Http\Controllers\admin\TaskController::class, 'task_save'])->name('task_save');
Route::post('/delete_task', [App\Http\Controllers\admin\TaskController::class, 'delete_task'])->name('delete_task');
Route::get('/task_edit/{id}', [App\Http\Controllers\admin\TaskController::class, 'task_edit'])->name('task_edit');
Route::post('/update_task', [App\Http\Controllers\admin\TaskController::class, 'update_task'])->name('update_task');
Route::post('/task_status', [App\Http\Controllers\admin\TaskController::class, 'task_status'])->name('task_status');
Route::get('/activity_list', [App\Http\Controllers\admin\TaskController::class, 'activity_list'])->name('activity_list');

