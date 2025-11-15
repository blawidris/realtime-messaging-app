<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    public function __construct(
        private ActivityLogService $activityLog
    ) {}

    public function uploadAttachment(
        Model $attachable,
        UploadedFile $file,
        User $user
    ): Attachment {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();
        $fullFilename = $filename . '.' . $extension;

        // Store file (configure disk in config/filesystems.php)
        $path = $file->storeAs(
            'attachments/' . date('Y/m'),
            $fullFilename,
            's3' // or 'public', 'local'
        );

        $attachment = Attachment::create([
            'tenant_id' => $user->currentTenant->id,
            'attachable_type' => get_class($attachable),
            'attachable_id' => $attachable->id,
            'user_id' => $user->id,
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'disk' => 's3',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);

        $this->activityLog->log('uploaded_attachment', $attachable, $user, [
            'description' => "Uploaded file: {$attachment->filename}",
            'attachment_id' => $attachment->id,
        ]);

        return $attachment;
    }

    public function deleteAttachment(Attachment $attachment): bool
    {
        // Delete physical file
        Storage::disk($attachment->disk)->delete($attachment->path);

        $this->activityLog->log('deleted_attachment', $attachment->attachable, auth()->user(), [
            'description' => "Deleted file: {$attachment->filename}",
        ]);

        return $attachment->delete();
    }

    public function downloadAttachment(Attachment $attachment): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::disk($attachment->disk)->download(
            $attachment->path,
            $attachment->filename
        );
    }
}
