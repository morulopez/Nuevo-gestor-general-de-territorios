
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Campaings extends CI_Controller {

	
	function __construct(){
			/**
			LLAMAMOS AL MODELO 'Campaings' PARA CREAR LAS SENTENCIAS EN LA DB
			**/
			parent::__construct();
			$this->load->model('Campaings_model');
	}
	function mis_campaing(){
		$html=$this->load->view("theme/campaing.php",["id" => $this->session->userdata['id']],true);
		$this->load->view("panel.php",["nombre_usuario" => $this->session->userdata['nombre'],
	                                   "congregacion"   => $this->session->userdata['nombre_congregacion'],
	                                   "contenido"      => $html]);
	}
	function nueva_campaing(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$data = $this->Campaings_model->crear_campaing($post);
		echo json_encode($data);
	}
	function req_campaing(){
		$data = $this->Campaings_model->req_campaings();
		echo json_encode($data);
	}
	function req_info_campaing(){
		if(!empty($this->input->post('id'))){
			$data = $this->Campaings_model->req_campaings_info($this->input->post('id'));
			echo json_encode(["vista"=>$this->load->view("theme/info_campaing.php",[
			 "id"=>$this->session->userdata['id'],
			 "datos"=>$data	
			],true),"datosnumber"=>$data['datos']['numero_territorios'],"datospredicados"=>$data['datos']['territorios_predicados']]);
		}
	}
	function desactivar_campaing(){
		if(!empty($this->input->post('id'))){
			$data = $this->Campaings_model->desactivar_campaing($this->input->post('id'));
			echo json_encode($data);
		}
	}
}