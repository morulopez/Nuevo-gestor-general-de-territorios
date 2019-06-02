
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Publicadores extends CI_Controller {

	function __construct(){
			/**
			LLAMAMOS AL MODELO 'DATOS_USUARIO' PARA CREAR LAS SENTENCIAS EN LA DB
			**/
			parent::__construct();
			$this->load->model('Datos_usuario');
	}
	/**
	Esta funcion la llamamos desde CDN/JS/login.js y el objeto (dataUser.dataUserAdmin()) y con ella obtenemos los 
	datos del usurio que termina ejecutandose en la vista theme/mi_perfil.php.
	**/
	function datos_admin(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$data = $this->Datos_usuario->data_user($post->id);
		echo json_encode($data);
	}
	function datos_service(){
		if($this->input->post("id")){
			$data = $this->Datos_usuario->service_year_info($this->input->post("id"));
			echo json_encode($data);
		}
	}
	/**
	Esta funcion la llamamos desde CDN/JS/login.js y el objeto (dataUser.update()) y con ella actualizamos los datos del administrador. Esta funcion termina ejecutandose en la vista theme/mi_perfil.php.
	**/
	function datos_update(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		if(!empty($post->id_nombre) || !empty($post->id_apellidos) || !empty($post->id_email)){
			if(!empty($post->id_nombre)){
				$data_update = $this->Datos_usuario->update_user_congre('nombre',$post->id_nombre);
				/**actualizamos los datos de la sesion*/
				$this->session->unset_userdata ('nombre');
				$this->session->set_userdata(['nombre' => $post->id_nombre]);
				echo json_encode($data_update);
			}elseif(!empty($post->id_apellidos)){
				$data_update = $this->Datos_usuario->update_user_congre('apellidos',$post->id_apellidos);
				echo json_encode($data_update);
			}elseif(!empty($post->id_email)){
				$this->load->helper('email');
				if(!valid_email($post->id_email)){
					$data_update = 'Email no valido';
					echo json_encode($data_update);
				}else{
					$data_update = $this->Datos_usuario->update_user_congre('email',$post->id_email);
					/**actualizamos los datos de la sesion*/
					$this->session->unset_userdata ('email');
					$this->session->set_userdata(['email' => $post->id_email]);
					echo json_encode($data_update);
					}
			}
		}else{
			if(!empty($post->id_nombre_congregacion)){
				$data_update = $this->Datos_usuario->update_user_congre('nombre_congre',$post->id_nombre_congregacion);
				/**actualizamos los datos de la sesion*/
				$this->session->unset_userdata ('nombre_congregacion');
				$this->session->set_userdata(['nombre_congregacion' => $post->id_nombre_congregacion]);
				echo json_encode($data_update);
			}elseif(!empty($post->id_provincia)){
				$data_update = $this->Datos_usuario->update_user_congre('provincia',$post->id_provincia);
				echo json_encode($data_update);
			}elseif(!empty($post->id_localidad)){
				$data_update = $this->Datos_usuario->update_user_congre('localidad',$post->id_localidad);
				echo json_encode($data_update);
			}

		}
		if(!$data_update){
			echo json_encode(false);
		}
	}
	/**
	Esta funcion simplemente carga la vista (theme/Publicadores.php) donde trabajamos con los datos de los publicadores
	**/
	function req_publicadores(){
		$html=$this->load->view("theme/Publicadores.php",["id" => $this->session->userdata['id']],true);
		$this->load->view("panel.php",["nombre_usuario" => $this->session->userdata['nombre'],
	                                   "congregacion"   => $this->session->userdata['nombre_congregacion'],
	                                   "contenido"      => $html]);
	}
	/**
	Esta funcion la cargamos desde CDN/JS/login.js y el objeto (dataUser.agregar_publicador()) y con ella agregamos al publicador.Esta funcion termina ejecutandose en la vista theme/publicadores.php
	**/
	function agregar_publicador(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		if($post->email!=''){
			$this->load->helper('email');
			if(!valid_email($post->email)){
				echo json_encode('Email no valido');
			}else{
				$res = $this->Datos_usuario->add_publicador($post);
				echo json_encode($res);
			}
		}else{
			$res = $this->Datos_usuario->add_publicador($post);
			echo json_encode($res);
		}
	}
	/**
	Esta funcion la llamamos desde CDN/JS/login.js y el objeto (dataUser.req_publicadores()) y con ella obtenemos todos los publicadores de la congregacion en concreto.
	Esta funcion termina ejecutandose en la vista theme/publicadores.php
	**/

	function req_all_publicadores(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$res      = $this->Datos_usuario->req_datos_publicadores($post->numpage);
		echo json_encode($res);
	}
	/**
	Esta funcion la llamamos mediante CDN/JS/login.js y el objeto (dataUser.ver_publicador()).Con ella obtenemos los datos de un publicador concreto y los mostramos en la vista que cargamos theme/info_publicador.php.
	Pero OJO! esta vista es ejecutada de manera asincrona si accedemos mediante la url a este controlador mostrará errores.Esta vista se ejecuta medante una venta modal finalmente en la vista theme/publicadores.php
	**/
	function info_publicador(){
		$postdata    = file_get_contents("php://input");
		$post        = json_decode($postdata);
		$datos_publi = $this->Datos_usuario->info_user($post->id);
		$this->load->model('Campaings_model');
		$comprobar_campaing = $this->Campaings_model->req_campaing();
		$this->load->model('Datos_usuario');
		$idserviceyear = $this->Datos_usuario->req_service_year();
		echo json_encode($this->load->view("theme/info_publicador.php",["id" => $this->session->userdata['id'],
	                                                                    "datos_publicador" => $datos_publi,
	                                                                    "campaingdata"  => $comprobar_campaing,
	                                                                    "idserviceyear" => $idserviceyear
	                                                                   ],true));
	}
	/**
	Esta funcion la llamamos mediante CDN/JS/login.js y el objeto (dataUser.update_publicador()).
	OJO! Esta funcion viene desde la vista theme/info_publicador.php la cual cargamos asincronamente y la mostramos en una ventana modal en la vista publicadores.php
	**/
	function update_publicador(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
			if(!empty($post->nombre)){
				$data_update = $this->Datos_usuario->update_publicador('nombre',$post->nombre,$post->id_publicador);
				echo json_encode($data_update);
			}elseif(!empty($post->email)){
				$this->load->helper('email');
				if(!valid_email($post->email)){
					echo json_encode('Email no valido');
				}else{
					$data_update = $this->Datos_usuario->update_publicador('email',$post->email,$post->id_publicador);
					echo json_encode($data_update);
				}
			}elseif(!empty($post->apellidos)){
				$data_update = $this->Datos_usuario->update_publicador('apellidos',$post->apellidos,$post->id_publicador);
				echo json_encode($data_update);
			}elseif(!empty($post->telefono)){
				$data_update = $this->Datos_usuario->update_publicador('telefono',$post->telefono,$post->id_publicador);
				echo json_encode($data_update);
			}
	}
	/**Funcion para asignar territorio al publicador**/
	function asignarterritorio(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$asignado = $this->Datos_usuario->asignarterritorio($post);
		echo json_encode($asignado);
	}
	function asignarterritorio_campaing(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$asignado = $this->Datos_usuario->asignarterritorio_campaing($post);
		echo json_encode($asignado);
	}
	/**Funcion para devolver los territorios**/
	function devolver_terri_servicio(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$devuelto = $this->Datos_usuario->devolver_terri_servicio($post);
		echo json_encode($devuelto);
	}
	/** Funcion para devolver los territorios de campaña**/
	function devolver_territorio_campaing(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$devuelto = $this->Datos_usuario->devolver_territorio_campaing($post);
		echo json_encode($devuelto);
	}
	function eliminar_publicador(){
		if($this->input->post('id')){
			$borrado = $this->Datos_usuario->eliminarusuario($this->input->post('id'));
			echo json_encode($borrado);
		}
	}
	/**Con esta funcion buscamos los publicadores que vienen desde la vista publicadores.php a traves del archivo usuarios.js*/
	function buscar_publi(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$data 	  = $this->Datos_usuario->buscar_publi($post);
		echo json_encode($data);
	}
	function mail_suport(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$this->load->library('Myphpmailer');
		$data     = $this->myphpmailer->mail_suport($post);
		echo json_encode($data);
	}
	function notificar_publicador(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		/*$this->load->library('Myphpmailer');
		$data     = $this->myphpmailer->mail_suport($post);*/
		echo json_encode($post);
	}
	function pru(){
		/*$territorios = $this->db->select('ID')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->get("territorios");
		$numero = $territorios->num_rows();
		echo $numero;*/
		$this->load->model('Login_model');
		$this->Login_model->new_service_year();
	}

}
