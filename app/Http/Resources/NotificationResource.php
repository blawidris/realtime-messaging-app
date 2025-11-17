<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'type_name' => $this->getTypeName(),
            'data' => $this->data,
            'read_at' => $this->read_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'time_ago' => $this->created_at->diffForHumans(),
            'is_read' => !is_null($this->read_at),
            'message' => $this->data['message'] ?? 'New notification',
        ];
    }

    private function getTypeName(): string
    {
        $type = class_basename($this->type);

        return match ($type) {
            'TaskAssignedNotification' => 'Task Assigned',
            'TaskStatusChangedNotification' => 'Task Status Changed',
            'TaskDueSoonNotification' => 'Task Due Soon',
            'TaskOverdueNotification' => 'Task Overdue',
            'TaskCompletedNotification' => 'Task Completed',
            'CommentMentionNotification' => 'Mentioned in Comment',
            'ProjectInvitationNotification' => 'Project Invitation',
            default => 'Notification',
        };
    }
}
