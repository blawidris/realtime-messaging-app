<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'subject_type',
        'subject_id',
        'action',
        'description',
        'ip_address',
        'user_agent'
    ];
}
