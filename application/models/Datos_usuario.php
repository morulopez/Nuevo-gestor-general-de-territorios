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
function add_publicador($data){
	if($data->nombrepublicador=="" || $data->apellidospublicador==""){
		return false;
	}if($data->email!=""){
		$comprovarexiste = $this->db->select('email')->where('email',$data->email)->get('publicadores');
			if($comprovarexiste->num_rows()>0){
				return $existe = 'El email ya existe por favor escoja otro';
			}
	}
	$array_insert_publicador = [
		        "ID_congregacion" => $this->session->userdata['id_congregacion'],
				"nombre"    	  => $data->nombrepublicador,
				"apellidos"		  => $data->apellidospublicador,
				"email" 		  => $data->email,
				"telefono" 		  => $data->telefono
			];

	$datos = $this->db->insert('publicadores',$array_insert_publicador);
	return true;
}

function req_datos_publicadores(){
	$publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta')->join('territorios','territorios.ID_publicador = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->get('publicadores');
	return $publicadores->result_array();
}

function info_user($id){
	$publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta')->join('territorios','territorios.ID_publicador = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->where('ID',$id)->get('publicadores');
	return $publicadores->row_array();
}



}