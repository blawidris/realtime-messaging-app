<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'action' => $this->action,
            'action_label' => $this->getActionLabel(),
            'description' => $this->description,
            'properties' => $this->properties,
            'changes' => $this->getFormattedChanges(),
            'user' => new UserResource($this->whenLoaded('user')),
            'subject_type' => class_basename($this->subject_type),
            'subject_id' => $this->subject_id,
            'subject' => $this->when(
                $this->relationLoaded('subject') && $this->subject,
                function () {
                    return [
                        'id' => $this->subject->id,
                        'type' => class_basename($this->subject_type),
                        'title' => $this->subject->title ?? $this->subject->name ?? 'N/A',
                    ];
                }
            ),
            'project_id' => $this->project_id,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at->toISOString(),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }


    /**
     * Get human-readable action label
     */
    private function getActionLabel(): string
    {
        return match ($this->action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'assigned' => 'Assigned',
            'unassigned' => 'Unassigned',
            'status_changed' => 'Status Changed',
            'priority_changed' => 'Priority Changed',
            'archived' => 'Archived',
            'commented' => 'Commented',
            'uploaded_attachment' => 'Uploaded File',
            'deleted_attachment' => 'Deleted File',
            'member_added' => 'Member Added',
            'member_removed' => 'Member Removed',
            default => ucfirst(str_replace('_', ' ', $this->action)),
        };
    }

    /**
     * Get formatted changes
     */
    private function getFormattedChanges(): ?array
    {
        $properties = $this->properties;

        if (empty($properties['old']) || empty($properties['new'])) {
            return null;
        }

        $changes = [];
        foreach ($properties['new'] as $key => $newValue) {
            $oldValue = $properties['old'][$key] ?? null;

            if ($oldValue != $newValue) {
                $changes[] = [
                    'field' => $this->formatFieldName($key),
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return empty($changes) ? null : $changes;
    }

    /**
     * Format field name for display
     */
    private function formatFieldName(string $field): string
    {
        return ucwords(str_replace('_', ' ', $field));
    }
}
