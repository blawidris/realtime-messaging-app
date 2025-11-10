<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'type',
        'name',
        'description',
        'avatar_url',
        'created_by',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // Users/members in conversation
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->withPivot(['role', 'joined_at', 'left_at', 'last_read_at', 'last_read_message_id', 'is_archived', 'is_pinned'])
            ->withTimestamps()
            ->wherePivotNull('left_at');
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

    // Creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Admins only
    public function admins()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->wherePivot('role', 'admin')
            ->wherePivotNull('left_at');
    }

    // Helper: Is user a member?
    public function hasMember(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    // Helper: Get or create one-to-one conversation
    public static function findOrCreateOneToOne(User $user1, User $user2): self
    {
        return self::where('type', 'private')
            ->whereHas('users', function ($q) use ($user1) {
                $q->where('user_id', $user1->id);
            })
            ->whereHas('users', function ($q) use ($user2) {
                $q->where('user_id', $user2->id);
            })
            ->first() ?? self::createOneToOne($user1, $user2);
    }

    private static function createOneToOne(User $user1, User $user2): self
    {
        $conversation = self::create(['type' => 'private']);
        $conversation->users()->attach([
            $user1->id => ['role' => 'member', 'joined_at' => now()],
            $user2->id => ['role' => 'member', 'joined_at' => now()],
        ]);
        return $conversation;
    }
}
