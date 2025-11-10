<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function getId($slug)
    {
        $status = self::where('slug', $slug)->first();
        return $status ? $status->id : null;
    }
}
