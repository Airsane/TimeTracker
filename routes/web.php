<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;
use App\Http\Controllers\TaskController;

Route::get('/admin/export-tasks', [TaskController::class, 'export']);
Route::post('/admin/import-tasks', [TaskController::class, 'import']);
