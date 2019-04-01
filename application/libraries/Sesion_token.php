<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Firebase\JWT\JWT;
require_once ('php-jwt-master/src/JWT.php');
require_once ('php-jwt-master/src/BeforeValidException.php');
require_once ('php-jwt-master/src/ExpiredException.php');

class Sesion_token{
	function __construct(){
		$this->key = "1234jesusregfpdodfpdflgl.>wwwalessadlasdfdflmdswprewprpwer..,.";
	}

	function make_sesion_token(){
		$this->CI=&get_instance();
	 	$tm=time();
		$token = array(
	    "iat" 	 =>  $tm,
	    "exp" 	 =>  $tm + 36000
		);
		$jwt = JWT::encode($token, $this->key);
		return $jwt;

	}
	function get_token($jwt){
		try {
			$decoded = JWT::decode($jwt, $this->key, array('HS256'));
			return $decoded;
		}
		catch (Exception $e){
		    if($e->getMessage() === 'Wrong number of segments'){
		    	return false;
		    }
		}
	}
}
