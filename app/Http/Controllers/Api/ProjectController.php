<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use App\Traits\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    use Helper;

    public function __construct(
        private ProjectService $service
    ) {}

    public function index(Request $request)
    {
        $projects = $this->service->paginated($request);

        [$data, $meta] = $this->extractPaginated($projects);

        return $this->responseJson(true, "", ["projects" => ProjectResource::collection($data), 'meta' => $meta]);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->service->createProject(
            $request->validated(),
            $request->user()
        );

        return $this->responseJson(
            true,
            'Project created successfully',
            ProjectResource::make($project),
            201
        );
    }

    public function show(Project $project)
    {
        $project->load(['status', 'creator', 'members', 'tasks.status']);

        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->service->updateProject(
            $project,
            $request->validated(),
            
        );

        return response()->json([
            'message' => 'Project updated successfully',
            'data' => new ProjectResource($project),
        ]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->service->deleteProject($project);

        return response()->json([
            'message' => 'Project deleted successfully',
        ]);
    }

    public function stats(Project $project): JsonResponse
    {

        $stats = $this->service->getProjectStats($project);

        return response()->json(['data' => $stats]);
    }

    public function addMember(Request $request, Project $project): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:manager,member,viewer',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        $this->service->addMember($project, $user, $request->role);

        return response()->json([
            'message' => 'Member added successfully',
        ]);
    }

    public function removeMember(Request $request, Project $project): JsonResponse
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        $this->service->removeMember($project, $user);

        return response()->json([
            'message' => 'Member removed successfully',
        ]);
    }
}
