
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Territorios extends CI_Controller {

	
	function __construct(){
		/**
			LLAMAMOS AL MODELO 'territorios_model' PARA CREAR LAS SENTENCIAS EN LA DB
			**/
			parent::__construct();
			$this->load->model('Territorios_model');
	}
	function add_img_territorio(){
		$objeto=$_FILES['objeto'];
		echo json_encode($this->input->post('id'));
	}
	function add_territorio(){
		$id_territorio=$this->Territorios_model->add_territorio_model($this->input->post('numero_terri'),$this->input->post('zona'));
		if($id_territorio=='Este numero de territorio ya tiene esta zona asignada, cambia el numero o la zona por favor'){
			echo json_encode($id_territorio);
		}elseif($_FILES){
			$this->load->library('Cloud_image');
			$img    = $this->cloud_image->subir_imagen($_FILES['objeto']['tmp_name'],$this->session->userdata['id_congregacion'],$this->session->userdata['nombre_congregacion']);
			$imagen = $this->Territorios_model->add_img_model($img['secure_url'],$id_territorio,$img['public_id']);
			echo json_encode($imagen);
		}else{
			echo json_encode($id_territorio);
		}

	}
}