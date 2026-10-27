<?php

namespace App\Services;

use App\Http\Requests\ProjectApiRequest;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public static function getProjects(): Collection
    {
        return Project::query()
            ->with('tasks')
            ->get();
    }

    public static function getProjectById(int $projectId): Project
    {
        return Project::where('project_id', $projectId)
            ->with('tasks')
            ->first();
    }

    public static function save(ProjectApiRequest $request, int $projectId): void
    {
        $project = self::getProjectById($projectId);

        $project->update([
            'project_name' => $request->input('project_name'),
            'project_description' => $request->input('project_description'),
        ]);
    }

    public static function getProjectsOnlyIdName(): array
    {
        return Project::query()
            ->select('project_id', 'project_name')
            ->get()
            ->toArray();
    }
}
