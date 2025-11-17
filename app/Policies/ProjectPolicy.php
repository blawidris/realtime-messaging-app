<?php 

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view projects list
    }

    public function view(User $user, Project $project): bool
    {
        // Check if user belongs to the project's tenant
        // if ($project->tenant_id !== $user->currentTenant->id) {
        //     return false;
        // }

        // Check if user is a member of the project
        return $project->hasMember($user);
    }

    public function create(User $user): bool
    {
        // Check if user has permission in their tenant
        // return $user->hasRole(['owner', 'admin', 'manager']);

        return true;
    }

    public function update(User $user, Project $project): bool
    {
        // if ($project->tenant_id !== $user->currentTenant->id) {
        //     return false;
        // }

        // Project creator or managers can update
        if ($project->created_by === $user->id) {
            return true;
        }

        $membership = $project->members()
            ->where('user_id', $user->id)
            ->first();

        return $membership && $membership->pivot->role === 'manager';
    }

    public function delete(User $user, Project $project): bool
    {
        // if ($project->tenant_id !== $user->currentTenant->id) {
        //     return false;
        // }

        // Only creator or tenant owners/admins can delete
        return $project->created_by === $user->id;
    }

    public function addMember(User $user, Project $project): bool
    {
        return $this->update($user, $project);
    }

    public function removeMember(User $user, Project $project): bool
    {
        return $this->update($user, $project);
    }
}