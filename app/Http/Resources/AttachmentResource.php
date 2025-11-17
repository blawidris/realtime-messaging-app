<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'original_filename' => $this->filename,
            'size' => $this->size,
            'size_formatted' => $this->formatBytes($this->size),
            'mime_type' => $this->mime_type,
            'type_category' => $this->getTypeCategory(),
            'extension' => $this->getExtension(),
            'disk' => $this->disk,
            'is_image' => $this->isImage(),
            'is_document' => $this->isDocument(),
            'is_video' => $this->isVideo(),
            'is_audio' => $this->isAudio(),
            'metadata' => $this->metadata,
            'description' => $this->metadata['description'] ?? null,
            'user' => new UserResource($this->whenLoaded('user')),
            'attachable_type' => class_basename($this->attachable_type),
            'attachable_id' => $this->attachable_id,
            'attachable' => $this->when(
                $this->relationLoaded('attachable'),
                function () {
                    return [
                        'id' => $this->attachable->id,
                        'type' => class_basename($this->attachable_type),
                        'title' => $this->attachable->title ?? $this->attachable->name ?? 'N/A',
                    ];
                }
            ),
            'download_url' => route('attachments.download', $this->id),
            'created_at' => $this->created_at->toISOString(),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }

    /**
     * Get file type category
     */
    private function getTypeCategory(): string
    {
        if (str_starts_with($this->mime_type, 'image/')) {
            return 'image';
        }

        if (str_starts_with($this->mime_type, 'video/')) {
            return 'video';
        }

        if (str_starts_with($this->mime_type, 'audio/')) {
            return 'audio';
        }

        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];

        if (in_array($this->mime_type, $documentTypes)) {
            return 'document';
        }

        $archiveTypes = [
            'application/zip',
            'application/x-rar-compressed',
            'application/x-7z-compressed',
            'application/x-tar',
        ];

        if (in_array($this->mime_type, $archiveTypes)) {
            return 'archive';
        }

        return 'other';
    }

    /**
     * Get file extension
     */
    private function getExtension(): string
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /**
     * Check if file is an image
     */
    private function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if file is a document
     */
    private function isDocument(): bool
    {
        return $this->getTypeCategory() === 'document';
    }

    /**
     * Check if file is a video
     */
    private function isVideo(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Check if file is audio
     */
    private function isAudio(): bool
    {
        return str_starts_with($this->mime_type, 'audio/');
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
