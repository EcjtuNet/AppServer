<?php
class Category extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['text'];

	public function articles()
	{
		return $this->belongsToMany('Article');
	}

	public function scopeNewest($query) {
		return $query->orderBy('created_at', 'desc');
	}
}