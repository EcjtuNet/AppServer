<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['type', 'content'];

    public static function record($type, $content)
    {
        return self::create([
            'type'    => $type,
            'content' => $content,
        ]);
    }

    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
