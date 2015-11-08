<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['text'];
    public function articles()
    {
        return $this->belongsToMany('Article');
    }
    public function scopeNewest($query) {
        return $query->orderBy('created_at', 'desc');
    }
}
