<?php
class Push extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['msg_id', 'title', 'message', 'received'];
	public function article() {
		return $this->belongsTo('Article');
	}
}