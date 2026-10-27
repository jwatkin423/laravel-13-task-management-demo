<?php

use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\TasksApiController;
use Illuminate\Support\Facades\Route;

Route::controller(TasksApiController::class)
    ->prefix('task')
    ->group(function () {
        Route::post('/reorder', 'reorder');
        Route::post('/edit/{taskId}', 'edit');
        Route::delete('/delete/{taskId}', 'delete');
    });

Route::controller(ProjectApiController::class)
    ->prefix('project')
    ->group(function () {
        Route::post('/edit/{projectId}', 'edit');
    });
