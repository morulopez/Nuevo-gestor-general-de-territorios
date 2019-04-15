<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_territorios extends CI_Controller {

	public function index(){

	}
	function Inicio(){
		$html=$this->load->view("theme/mi_perfil.php",["id" => $this->session->userdata['id'],],true);
		$this->load->view("panel.php",["nombre_usuario" => $this->session->userdata['nombre'],
	                                   "congregacion"   => $this->session->userdata['nombre_congregacion'],
	                                   "contenido"      => $html]);
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
	function territorios(){
		$html=$this->load->view('theme/territorios.php',["id" => $this->session->userdata['id']],true);
		$this->load->view('panel.php',[
			"nombre_usuario" => $this->session->userdata['nombre'],
	         "congregacion"  => $this->session->userdata['nombre_congregacion'],
			"contenido"      => $html]);
		/*$this->load->library('Cloud_image');
		$img=$this->cloud_image->borrar_img("carpeta_prueba/congregacion/nombre_deprueba2");
		var_dump($img);*/
	}
}

