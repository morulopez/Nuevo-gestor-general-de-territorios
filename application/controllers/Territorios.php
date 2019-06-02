
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
		$id_territorio=$this->Territorios_model->add_territorio_model($this->input->post('numero_terri'),trim($this->input->post('zona')));
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
	/*Funcion para agregar imagen a un territorio creado pero que no tiene imagen*/
	function add_img(){
			$this->load->library('Cloud_image');
			$img    = $this->cloud_image->subir_imagen($_FILES['objeto']['tmp_name'],$this->session->userdata['id_congregacion'],$this->session->userdata['nombre_congregacion']);
			$imagen = $this->Territorios_model->add_img_model($img['secure_url'],$this->input->post('id_territorio'),$img['public_id']);
			echo json_encode($imagen);
	}
	function update_img(){
		$img = $this->Territorios_model->update_img_model($this->input->post('id_territorio'),$_FILES['objeto']['tmp_name']);
		echo json_encode($img);
	}
	function req_all_territorios(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$res      = $this->Territorios_model->req_datos_territorios($post->numpage);
		echo json_encode($res);
	}
	function info_territorio(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$datos_terri = $this->Territorios_model->info_territorio($post->id);
		echo json_encode($this->load->view("theme/info_territorio.php",["id" => $this->session->userdata['id'],
	                                                                    "datos_territorio" => $datos_terri],true));
	}
	function createobservacion(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$datos_terri = $this->Territorios_model->crear_observacion($post->id_territorio,$post->obser,$post->fecha);
		echo json_encode($post);
	}
	function borrarObservacion(){
		if($this->input->post('id')){
			$delete=$this->Territorios_model->borrar_observacion($this->input->post('id'));
			echo json_encode($delete);
		}
	}
	function borrarObservacionhistorial(){
		if($this->input->post('id')){
			$delete=$this->Territorios_model->borrar_observacion_historial($this->input->post('id'));
			echo json_encode($delete);
		}
	}
	function eliminar_terri(){
		if($this->input->post('id')){
			$delete_territorio=$this->Territorios_model->eliminar_territorio($this->input->post('id'));
			echo json_encode($delete_territorio);
		}
	}
	function obtener_terri_asig(){
		if($this->input->post('idservice')){
			$territorios = $this->Territorios_model->req_terri_asigservicio($this->input->post('idservice'));
			echo json_encode($territorios);
		}
	}
	function obtener_terri_asig_cam(){
		if($this->input->post('id')){
			$territorios = $this->Territorios_model->req_terri_asigscamaping($this->input->post('id'));
			echo json_encode($territorios);
		}
	}
	function observaciones_asig(){
		$obser = $this->Territorios_model->obser_asig($this->input->post('id'));
		echo json_encode($obser);
	}
	function actualizar_territorio(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$update      = $this->Territorios_model->actualizar($post);
		echo json_encode($update);
	}
	function buscar_terri(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$territorios = $this->Territorios_model->buscar_terri($post->value);
		echo json_encode($territorios);
	}
	function filtrar_terri(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$territorios = $this->Territorios_model->filtrar_terri($post);
		echo json_encode($territorios);
	}
}