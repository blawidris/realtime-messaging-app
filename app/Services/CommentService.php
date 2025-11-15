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
        string $content
    ): Comment {
        return DB::transaction(function () use ($commentable, $user, $content) {
            $mentions = $this->extractMentions($content);

            $comment = Comment::create([
                'tenant_id' => $user->currentTenant->id,
                'commentable_type' => get_class($commentable),
                'commentable_id' => $commentable->id,
                'user_id' => $user->id,
                'content' => $content,
                'mentions' => $mentions,
            ]);

            // Log activity
            $this->activityLog->log('commented', $commentable, $user, [
                'description' => "Added a comment",
                'comment_id' => $comment->id,
            ]);

            // Notify mentioned users
            foreach ($mentions as $userId) {
                $mentionedUser = User::find($userId);
                if ($mentionedUser) {
                    $mentionedUser->notify(
                        new \App\Notifications\CommentMentionNotification($comment, $user->name)
                    );
                }
            }

            return $comment->load('user');
        });
    }

    public function updateComment(Comment $comment, string $content): Comment
    {
        $comment->update(['content' => $content]);

        $this->activityLog->log('updated_comment', $comment->commentable, auth()->user(), [
            'description' => "Updated a comment",
            'comment_id' => $comment->id,
        ]);

        return $comment->fresh();
    }

    public function deleteComment(Comment $comment): bool
    {
        $this->activityLog->log('deleted_comment', $comment->commentable, auth()->user(), [
            'description' => "Deleted a comment",
            'comment_content' => substr($comment->content, 0, 100),
        ]);

        return $comment->delete();
    }

    private function extractMentions(string $content): array
    {
        // Extract @mentions from content (e.g., @username or @[User Name](user_id))
        preg_match_all('/@\[.*?\]\((\d+)\)/', $content, $matches);
        return array_unique($matches[1] ?? []);
    }
}