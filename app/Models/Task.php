<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'parent_task_id',
        'title',
        'description',
        'status_id',
        'priority_id',
        'created_by',
        'order',
        'estimated_hours',
        'actual_hours',
        'due_at',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'due_at' => 'datetime',
        'estimated_hours' => 'integer',
        'actual_hours' => 'integer',
        'order' => 'integer',
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }
    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_users')
            ->withPivot('assigned_at', 'assigned_by')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // Scopes
    public function scopeForProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->whereHas('assignees', fn($q) => $q->where('user_id', $userId));
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_at', '<', now())
            ->whereHas('status', fn($q) => $q->where('is_closed', false));
    }

    public function scopeByStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    public function scopeByPriority($query, $priorityId)
    {
        return $query->where('priority_id', $priorityId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    // Helper Methods
    public function isOverdue(): bool
    {
        return $this->due_at && $this->due_at->isPast() && !$this->status->is_closed;
    }

    public function isCompleted(): bool
    {
        return $this->status->is_closed;
    }

    public function assignTo(User $user, ?User $assignedBy = null): void
    {
        $this->assignees()->attach($user->id, [
            'assigned_at' => now(),
            'assigned_by' => $assignedBy?->id ?? auth()?->id(),
        ]);
    }

    public function unassignFrom(User $user): void
    {
        $this->assignees()->detach($user->id);
    }

    public function isAssignedTo(User $user): bool
    {
        return $this->assignees()->where('user_id', $user->id)->exists();
    }

    public function updatePosition(int $newPosition): void
    {
        $this->update(['position' => $newPosition]);
    }
}
