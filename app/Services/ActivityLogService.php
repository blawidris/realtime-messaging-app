<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(
        string $action,
        Model $subject,
        ?User $user = null,
        array $properties = []
    ): ActivityLog {
        $user = $user ?? request()->user();

        return ActivityLog::create([
            'project_id' => $this->getProjectId($subject),
            'user_id' => $user?->id,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'action' => $action,
            'description' => $properties['description'] ?? null,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function getActivityFeed(int $tenantId, array $filters = [])
    {
        $query = ActivityLog::forTenant($tenantId)
            ->with(['user', 'subject'])
            ->orderBy('created_at', 'desc');

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['subject_type'])) {
            $query->where('subject_type', $filters['subject_type']);
        }

        if (!empty($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->where('created_at', '<=', $filters['to_date']);
        }

        return $query->paginate($filters['per_page'] ?? 50);
    }

    public function getProjectActivity(int $projectId, int $limit = 50)
    {
        return ActivityLog::where('project_id', $projectId)
            ->with(['user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTaskActivity(int $taskId)
    {
        return ActivityLog::where('subject_type', \App\Models\Task::class)
            ->where('subject_id', $taskId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getProjectId(Model $subject): ?int
    {
        if ($subject instanceof \App\Models\Project) {
            return $subject->id;
        }

        if ($subject instanceof \App\Models\Task && $subject->project_id) {
            return $subject->project_id;
        }

        return null;
    }
}