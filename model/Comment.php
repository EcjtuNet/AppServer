<?php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Illuminate\Database\Eloquent\Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $fillable = ['author', 'content'];

	public function scopeNewest ($query) {
		return $query->orderBy('created_at', 'desc');
	}
	
	public function commentable() {
		return $this->morphTo();
	}
}
