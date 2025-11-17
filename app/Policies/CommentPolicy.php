<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function view(User $user, Comment $comment): bool
    {
        // Check tenant
        if ($comment->tenant_id !== $user->currentTenant->id) {
            return false;
        }

        $commentable = $comment->commentable;

        if ($commentable instanceof \App\Models\Task) {
            return $commentable->project && $commentable->project->hasMember($user);
        }

        if ($commentable instanceof \App\Models\Project) {
            return $commentable->hasMember($user);
        }

        return false;
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create comments
    }

    public function update(User $user, Comment $comment): bool
    {

        // Only the comment owner can update
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        
        // Owner can delete
        if ($comment->user_id === $user->id) {
            return true;
        }

        // Project/task managers can delete
        $commentable = $comment->commentable;

        if ($commentable instanceof \App\Models\Task && $commentable->project) {
            $membership = $commentable->project->members()
                ->where('user_id', $user->id)
                ->first();

            return $membership && $membership->pivot->role === 'manager';
        }

        if ($commentable instanceof \App\Models\Project) {
            $membership = $commentable->members()
                ->where('user_id', $user->id)
                ->first();

            return $membership && $membership->pivot->role === 'manager';
        }

        return false;
    }
}
