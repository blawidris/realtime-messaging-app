<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Project;
use App\Services\TaskService;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use Helper;

    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(Request $request)
    {
        $tasks = $this->taskService->paginated($request);

        [$data, $meta] = $this->extractPaginated($tasks);

        return $this->responseJson(true, ['tasks' => TaskResource::collection($data), "Tasks fetched successfully", 'meta' => $meta],);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'Task created successfully',
            'data' => new TaskResource($task),
        ], 201);
    }

    public function show(Task $task)
    {
        $task->load([
            'status',
            'priority',
            'creator',
            'assignees',
            'project',
            'comments.user',
            'attachments',
            'subtasks.status',
        ]);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task = $this->taskService->updateTask(
            $task,
            $request->validated()
        );

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => new TaskResource($task),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->deleteTask($task);

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }

    public function assign(Request $request, Task $task): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        $task = $this->taskService->assignTask($task, $user);

        return response()->json([
            'message' => 'Task assigned successfully',
            'data' => new TaskResource($task),
        ]);
    }

    public function unassign(Request $request, Task $task): JsonResponse
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        $task = $this->taskService->unassignTask($task, $user);

        return response()->json([
            'message' => 'Task unassigned successfully',
            'data' => new TaskResource($task),
        ]);
    }

    public function changeStatus(Request $request, Task $task): JsonResponse
    {

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $task = $this->taskService->changeStatus($task, $request->status_id);

        return response()->json([
            'message' => 'Task status updated successfully',
            'data' => new TaskResource($task),
        ]);
    }

    public function changePriority(Request $request, Task $task): JsonResponse
    {

        $request->validate([
            'priority_id' => 'required|exists:priorities,id',
        ]);

        $task = $this->taskService->changePriority($task, $request->priority_id);

        return response()->json([
            'message' => 'Task priority updated successfully',
            'data' => new TaskResource($task),
        ]);
    }

    public function reorder(Request $request, Project $project): JsonResponse
    {

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id',
        ]);

        $this->taskService->reorderTasks(
            $project,
            $request->status_id,
            $request->task_ids
        );

        return response()->json([
            'message' => 'Tasks reordered successfully',
        ]);
    }
}
