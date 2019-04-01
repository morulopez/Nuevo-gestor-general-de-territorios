<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cookie_valid{

	function __construct(){}
	
	function create_cookie_valid(){
		$this->CI=&get_instance();
		$this->CI->load->helper('cookie');
		$cookie = array( 'name' => 'valid_register', 'value' => 'valido','expire'=>3600);
		set_cookie($cookie); 
	}
}
