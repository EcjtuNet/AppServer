<?php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Article extends Illuminate\Database\Eloquent\Model {
	use SoftDeletingTrait;
	protected $fillable = ['title', 'content', 'info', 'thumb'];
	protected $hidden = ['admin_id'];


	public function scopeNewest ($query) {
		return $query->orderBy('created_at', 'desc');
	}

	public function scopePublished ($query) {
		return $query->where('published', true);
	}

	public function scopeUntil ($query, $id) {
		return $query->where('id', '<', $id);
	}
	
	public function admin() {
		return $this->belongsTo('Admin');
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
		return $this->belongsToMany('Category');
	}

	public function addCategory($category) {
		if(!$category)
			return false;
		$this->categories()->save($category);
		return $this;
	}
}