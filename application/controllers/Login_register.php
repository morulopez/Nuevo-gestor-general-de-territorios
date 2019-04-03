<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_register extends CI_Controller {

		function __construct(){
			parent::__construct();
			$this->load->model('Login_model');
		}
	/* Este metodo es llamado desde el archivo de CDN/JS/login.js y el metodo secret_key() de forma asincrona por medio de fetch().Con el comprobamos la clave secreta para poder dar permiso al usuario y que acceda a la pagina de registro**/
	function comprobarKey(){
		if($this->input->post("key")){
			$key = $this->Login_model->secret_key($this->input->post("key"));
			if($key){ 
				/**CREAMOS UNA COOKIE PARA PROTEGER LA RUTA Y QUE NO SE PUEDA ACCEDER POR LA URL. ESTA COOKIE SE COMPRUEBA DESDE LOS HOOCK config/hoocks.php**/
				$this->load->library('Cookie_valid');
				$this->cookie_valid->create_cookie_valid();
				echo json_encode($key);
			}else{
				echo json_encode($key);
				}
		}
	}
	/**Funcion llamada desde CDN/JS/login.js y el metodo login_User() de forma asincrona por medio de fetch() y con el procedemos a verificar al usuario*/

	function login(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$validacion = $this->Login_model->login($post->usuario,$post->password);
		if(!$validacion && $validacion=='Necesitas activar tu cuenta, vaya a su correo electronico y compruebe el correo que le enviamos para activar su cuenta'){
			echo json_encode($validacion);
		}else{
			$this->load->library('Sesion_token');
			$jwt = $this->sesion_token->make_sesion_token();
			$array_sesion_token = [
				"token"           	  => $jwt,
				"id"                  => $validacion['ID'],
				"id_congregacion"     => $validacion['ID_congregacion'],
				"nombre"              => $validacion['nombre'],
				"nombre_congregacion" => $validacion['nombre_congregacion'],
				"email"               => $validacion['email']
			];
			$this->session->set_userdata($array_sesion_token);
			echo json_encode($validacion);
		}
	}
	/**Funcion llamada desde CDN/JS/login.js y el metodo register_user() de forma asincrona por medio de fetch() y con el procedemos a registrar al usuario*/
	function registro(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		/**USAMOS LA LIBRERIA QUE HEMOS CREADO PARA ENCRIPTAR EL PASSWORD QUE HEMOS RECOGIDO**/
		$this->load->library("Encrypt_object");
		$pass = $this->encrypt_object->encryptpass($post->password,$post->passwordvalidatte);
		if(!$pass){
			echo json_encode(false);
		}else{
			$siguiente = $this->Login_model->register($post,$pass);
			if($siguiente == 'El usuario o email ya existe por favor escoja otro'){
				echo json_encode($siguiente);
			}else{
				$this->send_email_validate($siguiente);
				echo json_encode($siguiente);
			}
		}
	}
	/**FUNCION PARA MANDAR EMAIL DE VALIDACION DE LA CUENTA CREADA.ESTA FUNCION LA LLAMAMOS DESDE registro() en este mismo controlador**/
	private function send_email_validate($valores){
		$this->load->library("Myphpmailer");
		$this->myphpmailer->email_validacion_cuenta($valores['email'],$valores['id'],$valores['nombre'],$valores['apellidos'],$valores['nombre_congregacion']);
	}

}