<?php
class Setting extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['key', 'value'];
	protected $primaryKey = 'key';
}