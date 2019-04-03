<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['post_controller'][]= function(){
	$this->CI=&get_instance();
	$this->CI->load->library('Sesion_token');
	if(!empty($this->CI->session->userdata['token'])){
	$valido = $this->CI->sesion_token->get_token($this->CI->session->userdata['token']);
		if($valido && uri_string()== 'login' || $valido && uri_string()=='registrarse'){
			redirect('/');
		}elseif(!$valido){
			$this->CI->session->sess_destroy();
			redirect('/login');
		}
	}else{ 
		$this->CI->load->helper('cookie');
        if(uri_string()!='login' && uri_string()!='registrarse' && uri_string()!='Login_register/comprobarKey'){
        	redirect('/login');
		}
		if(uri_string()== 'registrarse' && !get_cookie('valid_register')){
			redirect('/login');
		}
		if(uri_string()!= 'registrarse' && !empty(get_cookie('valid_register'))){
				delete_cookie('valid_register');
			}
	}
};

/*$hook['post_system'][]=function(){
	$this->CI=&get_instance();
	$this->CI->load->helper('cookie');
	if(uri_string()== 'registrarse' && !get_cookie('valid_register')){
			redirect('/login');
	}
	if(uri_string()!= 'registrarse' && !empty(get_cookie('valid_register'))){
				delete_cookie('valid_register');
			}
};*/
