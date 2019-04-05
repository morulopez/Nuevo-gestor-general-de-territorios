
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Publicadores extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('Datos_usuario');
	}
	function datos_admin(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$data = $this->Datos_usuario->data_user($post->id);
		echo  json_encode($data);
	}
	function datos_update(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		if(!empty($post->id_nombre) || !empty($post->id_apellidos) || !empty($post->id_email)){
			if(!empty($post->id_nombre)){
				$data_update = $this->Datos_usuario->update_user_congre('nombre',$post->id_nombre);
				/**actualizamos los datos de la sesion*/
				$this->session->unset_userdata ('nombre');
				$this->session->set_userdata(['nombre' => $post->id_nombre]);
			}elseif(!empty($post->id_apellidos)){
				$data_update = $this->Datos_usuario->update_user_congre('apellidos',$post->id_apellidos);
			}elseif(!empty($post->id_email)){
				$data_update = $this->Datos_usuario->update_user_congre('email',$post->id_email);
				/**actualizamos los datos de la sesion*/
				$this->session->unset_userdata ('email');
				$this->session->set_userdata(['email' => $post->id_email]);
			}
		}else{
			if(!empty($post->id_nombre_congregacion)){
				$data_update = $this->Datos_usuario->update_user_congre('nombre_congre',$post->id_nombre_congregacion);
				/**actualizamos los datos de la sesion*/
				$this->session->unset_userdata ('nombre_congregacion');
				$this->session->set_userdata(['nombre_congregacion' => $post->id_email]);
			}elseif(!empty($post->id_provincia)){
				$data_update = $this->Datos_usuario->update_user_congre('provincia',$post->id_provincia);
			}elseif(!empty($post->id_localidad)){
				$data_update = $this->Datos_usuario->update_user_congre('localidad',$post->id_localidad);
			}

		}
		if($data_update){
			echo json_encode($data_update);
		}else{
			echo json_encode(false);
		}
	}
	function req_publicadores(){
		$html=$this->load->view("theme/Publicadores.php",["id" => $this->session->userdata['id']],true);
		$this->load->view("panel.php",["nombre_usuario" => $this->session->userdata['nombre'],
	                                   "congregacion"   => $this->session->userdata['nombre_congregacion'],
	                                   "contenido"      => $html]);
	}
}
