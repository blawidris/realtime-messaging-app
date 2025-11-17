<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function __construct(
        private ActivityLogService $activityLog,
        private NotificationService $notificationService
    ) {}

    public function addComment(
        Model $commentable,
        User $user,
        string $content,
        ?int $parentId = null
    ): Comment {
        return DB::transaction(function () use ($commentable, $user, $content, $parentId) {
            $mentions = $this->extractMentions($content);

            $comment = Comment::create([
                'tenant_id' => $user->currentTenant->id,
                'commentable_type' => get_class($commentable),
                'commentable_id' => $commentable->id,
                'user_id' => $user->id,
                'parent_id' => $parentId,
                'content' => $content,
                'mentions' => $mentions,
            ]);

            // Log activity
            $this->activityLog->log('commented', $commentable, $user, [
                'description' => $parentId
                    ? "Replied to a comment"
                    : "Added a comment",
                'comment_id' => $comment->id,
                'content_preview' => substr($content, 0, 100),
            ]);

            // Notify mentioned users
            foreach ($mentions as $userId) {
                $mentionedUser = User::find($userId);
                if ($mentionedUser && $mentionedUser->id !== $user->id) {
                    $mentionedUser->notify(
                        new \App\Notifications\CommentMentionNotification($comment, $user->name)
                    );
                }
            }

            // Notify commentable owner if not the commenter
            if (method_exists($commentable, 'creator') && $commentable->creator) {
                if ($commentable->creator->id !== $user->id) {
                    $commentable->creator->notify(
                        new \App\Notifications\CommentAddedNotification($comment, $user->name)
                    );
                }
            }

            return $comment->load('user');
        });
    }

    public function updateComment(Comment $comment, string $content, User $user): Comment
    {
        $oldContent = $comment->content;
        $mentions = $this->extractMentions($content);

        $comment->update([
            'content' => $content,
            'mentions' => $mentions,
        ]);

        $this->activityLog->log('updated_comment', $comment->commentable, $user, [
            'description' => "Updated a comment",
            'comment_id' => $comment->id,
            'old_content' => substr($oldContent, 0, 100),
            'new_content' => substr($content, 0, 100),
        ]);

        // Notify newly mentioned users
        $newMentions = array_diff($mentions, $comment->getOriginal('mentions') ?? []);
        foreach ($newMentions as $userId) {
            $mentionedUser = User::find($userId);
            if ($mentionedUser && $mentionedUser->id !== $user->id) {
                $mentionedUser->notify(
                    new \App\Notifications\CommentMentionNotification(
                        $comment->fresh(),
                        $user->name
                    )
                );
            }
        }

        return $comment->fresh();
    }

    public function deleteComment(Comment $comment, User $user): bool
    {
        $this->activityLog->log('deleted_comment', $comment->commentable, $user, [
            'description' => "Deleted a comment",
            'content_preview' => substr($comment->content, 0, 100),
        ]);

        // Delete all replies
        $comment->replies()->delete();

        return $comment->delete();
    }

    /**
     * Extract user IDs from @mentions in content
     * Format: @[User Name](user_id)
     */
    private function extractMentions(string $content): array
    {
        preg_match_all('/@\[.*?\]\((\d+)\)/', $content, $matches);
        return array_unique($matches[1] ?? []);
    }

    /**
     * Get comment thread (parent + all replies)
     */
    public function getCommentThread(Comment $comment): array
    {
        $parent = $comment->parent_id ? Comment::find($comment->parent_id) : $comment;

        $replies = Comment::where('parent_id', $parent->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return [
            'parent' => $parent->load('user'),
            'replies' => $replies,
        ];
    }
}
