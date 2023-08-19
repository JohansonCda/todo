<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/task', [TaskController::class, 'index'])->name('task.index');
Route::post('api/task', [TaskController::class, 'store'])->name('task.store');
Route::put('api/task', [TaskController::class, 'updateTasks'])->name('task.updateTasks');
Route::delete('api/task', [TaskController::class, 'deleteTasks'])->name('task.deleteTasks');
Route::get('api/task/csv', [TaskController::class, 'csv'])->name('task.csv');
