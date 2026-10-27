<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::controller(TaskController::class)->group( function () {
    Route::get('/', 'index')->name('tasks.index');
    Route::get('/view/{taskId}', 'view')->name('task.view');
});

Route::controller(ProjectController::class)
    ->prefix('projects')
    ->group( function () {
        Route::get('/', 'index')->name('projects.index');
        Route::get('/view/{projectId}', 'view')->name('project.view');
    });
