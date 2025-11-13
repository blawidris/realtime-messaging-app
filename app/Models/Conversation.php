<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'description',
        'avatar',
        'created_by',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // All users (active members)
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_users')
            ->withPivot([
                'role', 'joined_at', 'left_at', 'last_read_at',
                'last_read_message_id', 'is_archived', 'is_pinned'
            ])
            ->withTimestamps()
            ->wherePivotNull('left_at');
    }

    // Creator of conversation
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // All messages
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    // Last message
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // Admins only
    public function admins()
    {
        return $this->belongsToMany(User::class, 'conversation_users')
            ->wherePivot('role', 'admin')
            ->wherePivotNull('left_at');
    }

    // Check if a user is a member
    public function hasMember(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    // Helper for one-to-one conversations
    public static function findOrCreateOneToOne(User $user1, User $user2): self
    {
        $existing = self::where('type', 'private')
            ->whereHas('users', fn($q) => $q->where('user_id', $user1->id))
            ->whereHas('users', fn($q) => $q->where('user_id', $user2->id))
            ->first();

        if ($existing) {
            return $existing;
        }

        $conversation = self::create(['type' => 'private', 'created_by' => $user1->id]);

        $conversation->users()->attach([
            $user1->id => ['role' => 'member', 'joined_at' => now()],
            $user2->id => ['role' => 'member', 'joined_at' => now()],
        ]);

        return $conversation;
    }
}
