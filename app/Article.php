<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'content', 'info', 'thumb'];
    protected $hidden = ['admin_id'];
    public function scopeNewest ($query) {
        return $query->orderBy('created_at', 'desc');
    }
    public function scopePublished ($query) {
        return $query->where('published', true);
    }
    public function scopeUntil ($query, $id) {
        return $query->where('id','<', $id);
    }
    public function admin() {
        return $this->belongsTo('App\Admin');
    }
    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }
    public function doPublish() {
        $this->published = true;
        $this->published_at = Carbon::now();
        $this->save();
        return $this;
    }
    public function doCancel() {
        $this->published = false;
        $this->save();
        return $this;
    }
    public function categories() {
        return $this->belongsToMany('App\Category');
    }
    public function addCategory($category) {
        if(!$category)
            return false;
        $this->categories()->save($category);
        return $this;
    }
    public function increClick() {
        $this->increment('click');
        return $this;
    }
}
