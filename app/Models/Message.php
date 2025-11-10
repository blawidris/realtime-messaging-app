<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    protected $fillable = [
        'uuid',
        'conversation_id',
        'user_id',
        'parent_id',
        'content',
        'type',
        'metadata',
        'edited_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'edited_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($message) {
            if (empty($message->uuid)) {
                $message->uuid = (string) Str::uuid();
            }
        });
    }

    // Belongs to conversation
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Sender
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Parent message (for threads/replies)
    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    // Replies
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    // Read receipts
    public function readBy()
    {
        return $this->belongsToMany(User::class, 'message_user')
            ->withPivot(['status', 'delivered_at', 'read_at'])
            ->withTimestamps();
    }

    // Unread count for a conversation
    public function scopeUnreadForUser($query, User $user, Conversation $conversation)
    {
        $lastRead = $conversation->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot
            ->last_read_at;

        return $query->where('conversation_id', $conversation->id)
            ->where('user_id', '!=', $user->id)
            ->where('created_at', '>', $lastRead ?? '1970-01-01');
    }
}
