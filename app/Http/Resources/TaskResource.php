<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'status' => new StatusResource($this->whenLoaded('status')),
            'priority' => new PriorityResource($this->whenLoaded('priority')),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'parent_task_id' => $this->parent_task_id,
            'parent_task' => new TaskResource($this->whenLoaded('parentTask')),
            'subtasks' => TaskResource::collection($this->whenLoaded('subtasks')),
            'position' => $this->position,
            'estimated_hours' => $this->estimated_hours,
            'actual_hours' => $this->actual_hours,
            "progress" => $this->progress(),
            'due_at' => $this->due_at?->toISOString(),
            'is_overdue' => $this->isOverdue(),
            'is_completed' => $this->isCompleted(),
            'metadata' => $this->metadata,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'assignees' => UserResource::collection($this->whenLoaded('assignees')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
