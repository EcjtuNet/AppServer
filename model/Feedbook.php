<?php
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
class Feedbook extends Illuminate\Database\Eloquent\Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $fillable = ['nikename', 'content'];

}