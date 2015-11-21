<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['author', 'content'];

    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
