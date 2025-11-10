<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MessageUser extends Pivot
{
     protected $table = 'message_users';

    protected $casts = [
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
