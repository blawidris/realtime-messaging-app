<?php 


namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        // Check if user has access to the project
        return $task->project && $task->project->hasMember($user);
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create tasks
    }

    public function update(User $user, Task $task): bool
    {
       
        // Task creator, assignees, or project managers can update
        if ($task->created_by === $user->id || $task->isAssignedTo($user)) {
            return true;
        }

        if (!$task->project) {
            return false;
        }

        $membership = $task->project->members()
            ->where('user_id', $user->id)
            ->first();

        return $membership && $membership->pivot->role === 'manager';
    }

    public function delete(User $user, Task $task): bool
    {
    
        // Task creator or project managers can delete
        if ($task->created_by === $user->id) {
            return true;
        }

        if (!$task->project) {
            return false;
        }

        $membership = $task->project->members()
            ->where('user_id', $user->id)
            ->first();

        return $membership && $membership->pivot->role === 'manager';
    }

    public function assign(User $user, Task $task): bool
    {
        return $this->update($user, $task);
    }
}