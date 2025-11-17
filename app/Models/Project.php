<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{

    protected $fillable = [
        'parent_id',
        'created_by',
        'name',
        'slug',
        'description',
        'status_id',
        'start_at',
        'due_at',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'start_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    public static function getId($name)
    {
        $project = self::where('name', $name)->first();

        return $project ? $project->id : null;
    }

    public function parent()
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Project::class, 'parent_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_users')->withPivot('role');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('status', fn($q) => $q->where('slug', 'active'));
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_at', '<', now())
            ->whereHas('status', fn($q) => $q->where('slug', 'overdue'));
    }

    // Helper Methods
    public function isOverdue(): bool
    {
        return $this->due_at && $this->due_at->isPast() && $this->status->slug !== 'completed';
    }

    public function completionPercentage(): float
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) return 0;

        $completedTasks = $this->tasks()
            ->whereHas('status', fn($q) => $q->where('is_closed', true))
            ->count();

        return round(($completedTasks / $totalTasks) * 100, 2);
    }

    public function addMember(User $user, string $role = 'member'): void
    {
        $this->members()->attach($user->id, ['role' => $role]);
    }

    public function removeMember(User $user): void
    {
        $this->members()->detach($user->id);
    }

    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
