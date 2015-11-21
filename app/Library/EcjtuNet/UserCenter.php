<?php
namespace App\Library\EcjtuNet;
use \Curl\Curl;
class UserCenter {
    const BASE_URL = 'user.ecjtu.net/api';
    public function __construct(){
        $this->curl = new Curl();
    }
    protected function get($url, $params=array()){
        $result = '';
        if($params)
            $result = $this->curl->get($url, $params);
        else
            $result = $this->curl->get($url);
        $result = json_decode($result, true);
        if(!isset($result['result']) || $result['result']==false)
            return false;
        return $result;
    }
    public function getUser($sid, $token=''){
        $result = '';
        if($token){
            $result = $this->get(self::BASE_URL.'/user/'.$sid, array(
                'token' => $token
            ));
        }else{
            $result = $this->get(self::BASE_URL.'/user/'.$sid);
        }
        if(!$result)
            return false;
        $user = $result['user'];
        return $user;
    }
}