<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['nikename','content'];
    public function scopeNewest ($query) {
        return $query->orderBy('id', 'desc');
    }
}
