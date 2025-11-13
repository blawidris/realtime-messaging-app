<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'status_id',
        "is_online",
        'last_seen_at',
        'phone_number',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
            'is_online' => 'boolean',
        ];
    }


    public function getFullName(): Attribute
    {
        return Attribute::get(function () {
            return "{$this->firstname} {$this->lastname}";
        });
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Conversations the user is part of
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
            ->withPivot(['role', 'joined_at', 'left_at', 'last_read_at', 'last_read_message_id', 'is_archived', 'is_pinned'])
            ->withTimestamps()
            ->wherePivotNull('left_at');
    }

    // Messages sent by user
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
