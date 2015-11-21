<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{
    protected $fillable = ['msg_id', 'title', 'message', 'received'];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
