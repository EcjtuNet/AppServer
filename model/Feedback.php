<?php
class Feedback extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['nikename','content'];

	public function scopeNewest ($query) {
		return $query->orderBy('id', 'desc');
	}
	
}