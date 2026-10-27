<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectApiRequest;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectApiController extends Controller
{
    public function edit(ProjectApiRequest $request, int $projectId)
    {
        if (!$request->validated()) {
            return response()->json(['status' => 'fail', 'message' => 'Unable to update the project']);
        }

        ProjectService::save($request, $projectId);

        return response()->json(['status' => 'success', 'message' => 'The project has been updated']);
    }
}
