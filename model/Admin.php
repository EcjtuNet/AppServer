<?php
class Admin extends Illuminate\Database\Eloquent\Model {
	protected $fillable = ['username', 'password'];
	static function login($username, $password)
	{
		return self::where(array(
			'username'=>$username,
			'password'=>self::salt($username, $password)
		))->first();
	}
	static function salt($username, $password)
	{
		$p = hash('sha256', $password);
		return hash('sha256', $username.$p);
	}
}