<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Route::get('/', function () {
//     return view('task');
// });
Route::get('/', [TaskController::class, 'TaskSelect'])->name('task.select');
Route::post('/task/create', [TaskController::class, 'TaskCreate'])->name('task.create');
Route::post('/task/access', [TaskController::class, 'TaskAccess'])->name('task.access');
Route::get('/get-dates', [TaskController::class, 'getDates']);