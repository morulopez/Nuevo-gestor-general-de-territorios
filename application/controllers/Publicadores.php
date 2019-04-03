
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Publicadores extends CI_Controller {

	
	function datos_admin(){
		$postdata = file_get_contents("php://input");
		$post     = json_decode($postdata);
		$this->load->model('Datos_usuario');
		$data = $this->Datos_usuario->data_user($post->id);
		echo  json_encode($data);
	}
}
