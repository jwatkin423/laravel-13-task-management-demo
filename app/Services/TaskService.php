<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{

    public static function reorderTaskPriorities(array $tasksFromApi = []): true
    {
        collect($tasksFromApi)->each(function ($task, $index) {
            Task::where('task_id', '=', $task['task_id'])
                ->update(['priority' => $index + 1]);
        });

        return true;
    }

    public static function getTaskOrderByPriority(): Collection
    {
        return Task::query()
            ->orderBy('tasks.priority')
            ->get();
    }

}
