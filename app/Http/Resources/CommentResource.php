<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'html_content' => $this->getHtmlContent(),
            'mentions' => $this->mentions,
            'mentioned_users' => $this->when(
                $this->mentions,
                function () {
                    return \App\Models\User::whereIn('id', $this->mentions ?? [])
                        ->get(['id', 'name', 'avatar'])
                        ->map(fn($user) => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'avatar' => $user->avatar,
                        ]);
                }
            ),
            'user' => new UserResource($this->whenLoaded('user')),
            'commentable_type' => class_basename($this->commentable_type),
            'commentable_id' => $this->commentable_id,
            'commentable' => $this->when(
                $this->relationLoaded('commentable'),
                function () {
                    return [
                        'id' => $this->commentable->id,
                        'type' => class_basename($this->commentable_type),
                        'title' => $this->commentable->title ?? $this->commentable->name ?? 'N/A',
                    ];
                }
            ),
            'parent_id' => $this->parent_id,
            'replies_count' => $this->when(
                $this->relationLoaded('replies'),
                fn() => $this->replies->count()
            ),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
            'is_edited' => $this->created_at != $this->updated_at,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }

    /**
     * Get HTML formatted content (with mentions highlighted)
     */
    private function getHtmlContent(): string
    {
        $content = e($this->content);

        // Convert mentions to links
        if ($this->mentions) {
            foreach ($this->mentions as $userId) {
                $user = \App\Models\User::find($userId);
                if ($user) {
                    $content = preg_replace(
                        "/@\[{$user->name}\]\({$userId}\)/",
                        "<span class=\"mention\" data-user-id=\"{$userId}\">@{$user->name}</span>",
                        $content
                    );
                }
            }
        }

        // Convert URLs to links
        $content = preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" rel="noopener">$1</a>',
            $content
        );

        // Convert line breaks to <br>
        $content = nl2br($content);

        return $content;
    }
}
