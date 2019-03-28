<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_register extends CI_Controller {

	function comprobarKey(){
		if($this->input->post("key")){
			$this->load->model("Login_model");
			$key = $this->Login_model->secret_key($this->input->post("key"));
			if($key){ 
				echo json_encode($key);
			}else{
				echo json_encode($key);
				}
		}
	}
	function registro(){

		$postdata = file_get_contents("php://input");
		$post=json_decode($postdata);
		/**USAMOS LA LIBRERIA QUE HEMOS CREADO PARA ENCRIPTAR EL PASSWORD QUE HEMOS RECOGIDO**/
		$this->load->library("Encrypt_object");
		$pass = $this->encrypt_object->encryptpass($post->password,$post->passwordvalidatte);
		if(!$pass){
			echo json_encode(false);
		}else{
			$this->load->model('Login_model');
			$siguiente = $this->Login_model->register($post,$pass);
			if($siguiente == 'El usuario o email ya existe por favor escoja otro'){
				echo json_encode($siguiente);
			}else{
				$this->mandar_email_validacion($siguiente);
				echo json_encode($siguiente);
			}
		}
	}
	private function mandar_email_validacion($valores){
		$this->load->library("Myphpmailer");
		$this->myphpmailer->email_validacion_cuenta($valores['email'],$valores['id'],$valores['nombre'],$valores['apellidos'],$valores['nombre_congregacion']);
	}

}