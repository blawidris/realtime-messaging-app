<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        private CommentService $commentService
    ) {}

    /**
     * Get all comments for a commentable (Task or Project)
     */
    public function index(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|in:task,project',
            'commentable_id' => 'required|integer',
        ]);

        $commentableType = $request->commentable_type === 'task' 
            ? Task::class 
            : Project::class;

        $commentable = $commentableType::findOrFail($request->commentable_id);


        $comments = Comment::where('commentable_type', $commentableType)
            ->where('commentable_id', $request->commentable_id)
            ->whereNull('parent_id') // Only top-level comments
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return CommentResource::collection($comments);
    }

    /**
     * Store comment on a task
     */
    public function storeOnTask(StoreCommentRequest $request, Task $task): JsonResponse
    {

        $comment = $this->commentService->addComment(
            $task,
            $request->user(),
            $request->comment,
            $request->parent_id
        );

        return response()->json([
            'message' => 'Comment added successfully',
            'data' => new CommentResource($comment),
        ], 201);
    }

    /**
     * Store comment on a project
     */
    public function storeOnProject(StoreCommentRequest $request, Project $project): JsonResponse
    {
        // $this->authorize('view', $project);

        $comment = $this->commentService->addComment(
            $project,
            $request->user(),
            $request->comment
        );

        return response()->json([
            'message' => 'Comment added successfully',
            'data' => new CommentResource($comment),
        ], 201);
    }

    /**
     * Get a specific comment
     */
    public function show(Comment $comment)
    {
        // $this->authorize('view', $comment);

        return new CommentResource($comment->load(['user', 'replies.user']));
    }

    /**
     * Update a comment
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        // $this->authorize('update', $comment);

        $comment = $this->commentService->updateComment(
            $comment,
            $request->comment,
            $request->user()
        );

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => new CommentResource($comment),
        ]);
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment, Request $request): JsonResponse
    {
        $this->commentService->deleteComment($comment, $request->user());

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }

    /**
     * Get replies for a comment
     */
    public function replies(Comment $comment)
    {
        // $this->authorize('view', $comment);

        $replies = $comment->replies()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return CommentResource::collection($replies);
    }

    /**
     * Reply to a comment
     */
    public function reply(StoreCommentRequest $request, Comment $comment): JsonResponse
    {
        // $this->authorize('view', $comment);

        $reply = $this->commentService->addComment(
            $comment->commentable,
            $request->user(),
            $request->comment,
        );

        return response()->json([
            'message' => 'Reply added successfully',
            'data' => new CommentResource($reply),
        ], 201);
    }

    /**
     * Get user's comments
     */
    public function userComments(Request $request)
    {
        $userId = $request->user_id ?? $request->id();

        $comments = Comment::forTenant($request->user()->currentTenant->id)
            ->where('user_id', $userId)
            ->with(['user', 'commentable'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return CommentResource::collection($comments);
    }

    /**
     * Search comments
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $comments = Comment::forTenant($request->user()->currentTenant->id)
            ->where('content', 'like', "%{$request->query}%")
            ->with(['user', 'commentable'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return CommentResource::collection($comments);
    }
}