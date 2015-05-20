<?php
use \Curl\Curl;
class UserCenter {
	const BASE_URL = 'user.ecjtu.net/api'
	public function __construct($sid='', $token=''){
		$this->curl = new Curl();
		$this->sid = $sid;
		$this->token = $token;
		if($sid && $token)
			return $this->getUser($sid, $token);
	}
	protected function get($url, $params=array()){
		$result = '';
		if($params)
			$result = $this->curl->get($url, $params);
		else
			$result = $this->curl->get($url);
		$result = json_decode($result);
		if(!isset($result['result']) || $result['result']==false)
			return false;
		return $result;
	}
	public function getAvatar($sid){
		$result = $this->get(self::BASE_URL.'/user/'.$sid);
		if(!$result)
			return false;
		$avatar = $result['user']['avatar'];
		return $avatar;
	}
	public function getUser($sid, $token){
		$result = $this->get(self::BASE_URL.'/user/'.$sid, array(
			'token' => $token
		));
		if(!$result)
			return false;
		$user = $result['user'];
		return $user;
	}
}