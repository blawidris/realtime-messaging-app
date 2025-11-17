<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{

    protected $fillable = ['name', 'slug', 'color', 'level'];

    public static function getId($slug)
    {
        $status = self::where('slug', $slug)->first();
        return $status ? $status->id : null;
    }
}
