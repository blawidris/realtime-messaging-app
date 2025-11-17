<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Task;
use App\Services\AttachmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function __construct(
        private AttachmentService $attachmentService
    ) {}

    /**
     * Get all attachments for an attachable (Task or Project)
     */
    public function index(Request $request)
    {
        $request->validate([
            'attachable_type' => 'required|in:task,project',
            'attachable_id' => 'required|integer',
        ]);

        $attachableType = $request->attachable_type === 'task'
            ? Task::class
            : Project::class;

        $attachable = $attachableType::findOrFail($request->attachable_id);

        $attachments = Attachment::where('attachable_type', $attachableType)
            ->where('attachable_id', $request->attachable_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return AttachmentResource::collection($attachments);
    }

    /**
     * Upload attachment to a task
     */
    public function storeOnTask(Request $request, Task $task): JsonResponse
    {

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'files' => 'sometimes|array',
            'files.*' => 'file|max:10240',
        ]);

        $attachments = [];

        // Handle single file upload
        if ($request->hasFile('file')) {
            $attachment = $this->attachmentService->uploadAttachment(
                $task,
                $request->file('file'),
                $request->user()
            );
            $attachments[] = $attachment;
        }

        // Handle multiple files upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attachment = $this->attachmentService->uploadAttachment(
                    $task,
                    $file,
                    $request->user()
                );
                $attachments[] = $attachment;
            }
        }

        return response()->json([
            'message' => count($attachments) . ' file(s) uploaded successfully',
            'data' => AttachmentResource::collection($attachments),
        ], 201);
    }

    /**
     * Upload attachment to a project
     */
    public function storeOnProject(Request $request, Project $project): JsonResponse
    {

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'files' => 'sometimes|array',
            'files.*' => 'file|max:10240',
        ]);

        $attachments = [];

        // Handle single file upload
        if ($request->hasFile('file')) {
            $attachment = $this->attachmentService->uploadAttachment(
                $project,
                $request->file('file'),
                $request->user()
            );
            $attachments[] = $attachment;
        }

        // Handle multiple files upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $attachment = $this->attachmentService->uploadAttachment(
                    $project,
                    $file,
                    $request->user()
                );
                $attachments[] = $attachment;
            }
        }

        return response()->json([
            'message' => count($attachments) . ' file(s) uploaded successfully',
            'data' => AttachmentResource::collection($attachments),
        ], 201);
    }

    /**
     * Get a specific attachment
     */
    public function show(Attachment $attachment)
    {

        return new AttachmentResource($attachment->load(['user', 'attachable']));
    }

    /**
     * Download an attachment
     */
    public function download(Attachment $attachment)
    {

        return $this->attachmentService->downloadAttachment($attachment);
    }

    /**
     * Get attachment preview/URL
     */
    public function preview(Attachment $attachment): JsonResponse
    {

        $url = Storage::disk($attachment->disk)->temporaryUrl(
            $attachment->path,
            now()->addMinutes(5)
        );

        return response()->json([
            'url' => $url,
            'expires_at' => now()->addMinutes(5)->toISOString(),
        ]);
    }

    /**
     * Delete an attachment
     */
    public function destroy(Attachment $attachment): JsonResponse
    {
        $this->attachmentService->deleteAttachment($attachment);

        return response()->json([
            'message' => 'Attachment deleted successfully',
        ]);
    }

    /**
     * Delete multiple attachments
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'attachment_ids' => 'required|array',
            'attachment_ids.*' => 'exists:attachments,id',
        ]);

        $count = 0;
        foreach ($request->attachment_ids as $attachmentId) {
            $attachment = Attachment::find($attachmentId);

            if ($attachment && $request->user()->can('delete', $attachment)) {
                $this->attachmentService->deleteAttachment($attachment);
                $count++;
            }
        }

        return response()->json([
            'message' => "{$count} attachment(s) deleted successfully",
            'count' => $count,
        ]);
    }

    /**
     * Update attachment metadata
     */
    public function updateMetadata(Request $request, Attachment $attachment): JsonResponse
    {
        $request->validate([
            'filename' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:500',
        ]);

        $attachment->update($request->only(['filename']));

        if ($request->has('description')) {
            $metadata = $attachment->metadata ?? [];
            $metadata['description'] = $request->description;
            $attachment->update(['metadata' => $metadata]);
        }

        return response()->json([
            'message' => 'Attachment updated successfully',
            'data' => new AttachmentResource($attachment),
        ]);
    }

    /**
     * Get attachments by type (images, documents, etc.)
     */
    public function byType(Request $request)
    {
        $request->validate([
            'type' => 'required|in:image,document,video,audio,archive,other',
            'attachable_type' => 'sometimes|in:task,project',
            'attachable_id' => 'sometimes|integer',
        ]);

        $mimeTypes = $this->getMimeTypesByCategory($request->type);

        $query = Attachment::where('user_id', $request->user()->id)->whereIn('mime_type', $mimeTypes)
            ->with(['user', 'attachable']);

        if ($request->attachable_type && $request->attachable_id) {
            $attachableType = $request->attachable_type === 'task'
                ? Task::class
                : Project::class;

            $query->where('attachable_type', $attachableType)
                ->where('attachable_id', $request->attachable_id);
        }

        $attachments = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return AttachmentResource::collection($attachments);
    }

    /**
     * Get user's uploads
     */
    public function userUploads(Request $request)
    {
        $userId = $request->user_id ?? $request->id();

        $attachments = Attachment::where('user_id', $userId)
            ->with(['attachable'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return AttachmentResource::collection($attachments);
    }

    /**
     * Get storage statistics
     */
    public function stats(Request $request): JsonResponse
    {
        $tenantId = $request->user()->currentTenant->id;

        $stats = [
            'total_attachments' => Attachment::forTenant($tenantId)->count(),
            'total_size' => Attachment::forTenant($tenantId)->sum('size'),
            'total_size_formatted' => $this->formatBytes(
                Attachment::forTenant($tenantId)->sum('size')
            ),
            'by_type' => Attachment::forTenant($tenantId)
                ->selectRaw('
                    CASE 
                        WHEN mime_type LIKE "image%" THEN "images"
                        WHEN mime_type LIKE "video%" THEN "videos"
                        WHEN mime_type LIKE "audio%" THEN "audio"
                        WHEN mime_type IN ("application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document") THEN "documents"
                        WHEN mime_type IN ("application/zip", "application/x-rar-compressed", "application/x-7z-compressed") THEN "archives"
                        ELSE "other"
                    END as type,
                    COUNT(*) as count,
                    SUM(size) as total_size
                ')
                ->groupBy('type')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->type => [
                        'count' => $item->count,
                        'size' => $item->total_size,
                        'size_formatted' => $this->formatBytes($item->total_size),
                    ]];
                }),
            'by_user' => Attachment::forTenant($tenantId)
                ->selectRaw('user_id, COUNT(*) as count, SUM(size) as total_size')
                ->with('user:id,name,avatar')
                ->groupBy('user_id')
                ->orderByDesc('count')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'user' => [
                            'id' => $item->user->id,
                            'name' => $item->user->name,
                            'avatar' => $item->user->avatar,
                        ],
                        'count' => $item->count,
                        'size' => $item->total_size,
                        'size_formatted' => $this->formatBytes($item->total_size),
                    ];
                }),
            'recent_uploads' => Attachment::forTenant($tenantId)
                ->with(['user', 'attachable'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(fn($attachment) => new AttachmentResource($attachment)),
        ];

        return response()->json(['data' => $stats]);
    }

    /**
     * Search attachments
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $attachments = Attachment::where('filename', 'like', "%{$request->query}%")
            ->with(['user', 'attachable'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return AttachmentResource::collection($attachments);
    }

    /**
     * Get MIME types by category
     */
    private function getMimeTypesByCategory(string $category): array
    {
        return match ($category) {
            'image' => [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'image/webp',
                'image/bmp'
            ],
            'document' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain',
            ],
            'video' => [
                'video/mp4',
                'video/mpeg',
                'video/quicktime',
                'video/x-msvideo',
                'video/webm'
            ],
            'audio' => [
                'audio/mpeg',
                'audio/wav',
                'audio/ogg',
                'audio/webm'
            ],
            'archive' => [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-7z-compressed',
                'application/x-tar'
            ],
            default => [],
        };
    }

    /**
     * Format bytes to human-readable size
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
