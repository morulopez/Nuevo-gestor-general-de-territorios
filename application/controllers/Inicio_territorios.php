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
}

