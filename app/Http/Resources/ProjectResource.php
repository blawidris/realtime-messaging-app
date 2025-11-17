<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => new StatusResource($this->whenLoaded('status')),
            'parent_id' => $this->parent_id,
            'parent' => new ProjectResource($this->whenLoaded('parent')),
            'children' => ProjectResource::collection($this->whenLoaded('children')),
            'start_at' => $this->start_at?->toISOString(),
            'due_at' => $this->due_at?->toISOString(),
            'is_overdue' => $this->isOverdue(),
            'completion_percentage' => $this->completionPercentage(),
            'meta' => $this->meta,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'members' => UserResource::collection($this->whenLoaded('members')),
            'tasks_count' => $this->when(isset($this->tasks_count), $this->tasks_count),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
