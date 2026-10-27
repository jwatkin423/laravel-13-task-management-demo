<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskApiRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksApiController extends Controller
{
    /**
     * reorders the task based on priority
     *
     * @param TaskApiRequest $taskApiRequest
     * @return JsonResponse
     */
    public function reorder(TaskApiRequest $taskApiRequest): JsonResponse
    {
        $results = false;
        if ($taskApiRequest->validated()) {
            $results = TaskService::reorderTaskPriorities($taskApiRequest->tasks);
        }

        if ($results) {
            return response()->json(['status' => 'success', 'message' => 'Tasks updated successfully!']);
        }

        return response()->json(['status' => 'fail', 'message' => 'Unable to reorder the tasks']);
    }

    public function edit(TaskRequest $request, int $taskId)
    {
        if (!$request->validated()) {
            return response()->json(['status' => 'fail', 'message' => 'Unable to update the tasks']);
        }

        $task = Task::find($taskId);

        $task->update([
           'name' => $request->input('name'),
           'project_id' => $request->input('project_id'),
           'status' => $request->input('status'),
        ]);

        return response()->json(['status' => 'success', 'message' => 'The task has been updated']);
    }

    public function delete(Request $request, int $taskId)
    {
        $task = Task::find($taskId);

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Successfully deleted the task!",
        ]);
    }
}
