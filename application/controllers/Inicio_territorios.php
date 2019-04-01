<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_territorios extends CI_Controller {

	public function index(){

	}
	function Inicio(){
		$this->load->view("panel.php");
	}

	function Login(){
		$this->load->view("login.php");
	}

	function pagina_registro(){
		$this->load->view("registro.php");
	}
	function activacion($key){
		$clave=explode("-",$key);
		$claveString="";
		foreach($clave as $clave2){
			$claveString.=$clave2;
		}
		$this->load->model('Login_model');
		$data = $this->Login_model->activate_account($claveString,$clave[1]);
		redirect('/login');	
	}
}

