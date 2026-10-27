<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use App\Models\Task;
use App\Services\TaskService;
use Inertia\Inertia;
use Inertia\Response;


class TaskController extends Controller
{
    private array $projects = [];

    public function __construct()
    {
        $this->projects = ProjectService::getProjectsOnlyIdName();
    }

    public function index(): Response
    {
        $tasks = TaskService::getTaskOrderByPriority();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'projects' => $this->projects,
        ]);
    }

    public function view(int $taskId): Response
    {

        $task = Task::find($taskId);

        return Inertia::render('Tasks/View', [
           'task' => $task,
            'projects' => $this->projects,
        ]);
    }
}
