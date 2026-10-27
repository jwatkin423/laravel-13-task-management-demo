<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = ProjectService::getProjects();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
        ]);
    }

    public function view(int $projectId)
    {
        $project = ProjectService::getProjectById($projectId);

        return Inertia::render('Projects/View', [
            'project' => $project,
        ]);
    }
}
