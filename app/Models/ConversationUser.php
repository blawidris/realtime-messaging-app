<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ConversationUser extends Pivot
{

    protected $table = 'conversation_users';

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'last_read_at' => 'datetime',
        'notifications_enabled' => 'boolean',
        'is_archived' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastReadMessage()
    {
        return $this->belongsTo(Message::class, 'last_read_message_id');
    }
}
