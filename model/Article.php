<?php
use Carbon\Carbon;
class Article extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['title', 'content'];
	public function author() {
		return $this->hasOne('Admin');
	}
	public function doPublish() {
		$this->publish = true;
		$this->published_at = Carbon::now();
		return $this;
	}
}