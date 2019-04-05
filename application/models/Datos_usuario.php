<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_usuario extends CI_Model{


function data_user($id){
	$User_data = $this->db->select('administrador.nombre,administrador.email,administrador.apellidos,congregaciones.nombre as nombre_congregacion,congregaciones.provincia,congregaciones.localidad')->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->where('administrador.ID',$id)->get('administrador');
	return $User_data = $User_data->row_array();
}

function update_user_congre($dato,$valor){
	if($dato=='nombre'){
		$actualizar = $this->db->set('nombre',$valor)->where('ID',$this->session->userdata['id'])->update('administrador');
		$this->db->set('nombre',$valor)->where('email',$this->session->userdata['email'])->update('publicadores');
			return true;
	}elseif($dato=='apellidos'){
		$actualizar = $this->db->set('apellidos',$valor)->where('ID',$this->session->userdata['id'])->update('administrador');
			$this->db->set('apellidos',$valor)->where('email',$this->session->userdata['email'])->update('publicadores');
				return true;
	}elseif($dato=='email'){
		$actualizar = $this->db->set('email',$valor)->where('ID',$this->session->userdata['id'])->update('administrador');
			$this->db->set('email',$valor)->where('email',$this->session->userdata['email'])->update('publicadores');
				return true;
	}elseif($dato=='nombre_congre'){
		$actualizar = $this->db->set('nombre',$valor)->where('ID',$this->session->userdata['id'])->update('congregaciones');
				return true;
	}elseif($dato=='provincia'){
		$actualizar = $this->db->set('provincia',$valor)->where('ID',$this->session->userdata['id'])->update('congregaciones');
				return true;
	}elseif($dato=='localidad'){
		$actualizar = $this->db->set('localidad',$valor)->where('ID',$this->session->userdata['id'])->update('congregaciones');
			 return true;
	}
}






}