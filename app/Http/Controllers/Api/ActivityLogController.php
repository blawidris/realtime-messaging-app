<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Get activity logs with filters
     */
    public function index(Request $request)
    {
        $query = ActivityLog::forTenant($request->user()->currentTenant->id)
            ->with(['user', 'subject']);

        // Apply filters
        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->subject_type) {
            $subjectType = $this->getSubjectTypeClass($request->subject_type);
            $query->where('subject_type', $subjectType);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        // Search in description
        if ($request->search) {
            $query->where('description', 'like', "%{$request->search}%");
        }

        $activities = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 50);

        return ActivityLogResource::collection($activities);
    }

    /**
     * Get activity log by ID
     */
    public function show(ActivityLog $activityLog)
    {
        // $this->authorize('view', $activityLog);

        return new ActivityLogResource($activityLog->load(['user', 'subject']));
    }

    /**
     * Get project activity logs
     */
    public function project(Project $project, Request $request)
    {
        // $this->authorize('view', $project);

        $query = ActivityLog::where('project_id', $project->id)
            ->with(['user', 'subject']);

        // Apply filters
        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $activities = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 50);

        return ActivityLogResource::collection($activities);
    }

    /**
     * Get task activity logs
     */
    public function task(Task $task, Request $request)
    {
        // $this->authorize('view', $task);

        $query = ActivityLog::where('subject_type', Task::class)
            ->where('subject_id', $task->id)
            ->with('user');

        // Apply filters
        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        $activities = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 50);

        return ActivityLogResource::collection($activities);
    }

    /**
     * Get user's activity logs
     */
    public function user(Request $request)
    {
        $userId = $request->user_id ?? $request->id();

        $query = ActivityLog::forTenant($request->user()->currentTenant->id)
            ->where('user_id', $userId)
            ->with(['subject']);

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        $activities = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 50);

        return ActivityLogResource::collection($activities);
    }

    /**
     * Get activity statistics
     */
    public function stats(Request $request): JsonResponse
    {
        $query = ActivityLog::where($request->user()->id);

        if ($request->project) {
            $query->where('project_id', $request->project);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $stats = [
            'total_activities' => $query->count(),
            'by_action' => $query->selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->pluck('count', 'action'),
            'by_user' => $query->selectRaw('user_id, COUNT(*) as count')
                ->groupBy('user_id')
                ->with('user:id,name')
                ->get()
                ->pluck('count', 'user.name'),
            'by_date' => $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->limit(30)
                ->pluck('count', 'date'),
        ];

        return response()->json(['data' => $stats]);
    }

    /**
     * Delete old activity logs (admin only)
     */
    public function cleanup(Request $request): JsonResponse
    {
        // $this->authorize('cleanup', ActivityLog::class);

        $request->validate([
            'older_than_days' => 'required|integer|min:30',
        ]);

        $date = now()->subDays($request->older_than_days);
        
        $count = ActivityLog::forTenant($request->user()->currentTenant->id)
            ->where('created_at', '<', $date)
            ->delete();

        return response()->json([
            'message' => "Deleted {$count} activity logs older than {$request->older_than_days} days",
            'count' => $count,
        ]);
    }

    /**
     * Export activity logs
     */
    public function export(Request $request): JsonResponse
    {
        $query = ActivityLog::forTenant($request->user()->currentTenant->id)
            ->with(['user', 'subject']);

        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        // Queue export job
        // dispatch(new ExportActivityLogsJob($query, $request->user()));

        return response()->json([
            'message' => 'Activity log export has been queued. You will receive an email when ready.',
        ]);
    }

    /**
     * Get subject type class from string
     */
    private function getSubjectTypeClass(string $type): string
    {
        return match(strtolower($type)) {
            'project' => Project::class,
            'task' => Task::class,
            'comment' => \App\Models\Comment::class,
            default => $type,
        };
    }
}