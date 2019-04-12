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
function update_publicador($dato,$valor,$id){
	if($dato=='nombre'){
		$actualizar = $this->db->set('nombre',$valor)->where('ID',$id)->update('publicadores');
			return true;
	}elseif($dato=='apellidos'){
		$actualizar = $this->db->set('apellidos',$valor)->where('ID',$id)->update('publicadores');
			return true;
	}elseif($dato=='email'){
		$confirmar = $this->db->select('ID,email')->where('email',$valor)->get('publicadores');
		$confirmar2=$confirmar->row_array();
		if($confirmar2['ID'] == $id){
			return true;
		}elseif($confirmar->num_rows()>0){
			return 'El email ya existe, escoja otro por favor';
		}
		$actualizar = $this->db->set('email',$valor)->where('ID',$id)->update('publicadores');
			return true;
	}elseif($dato=='telefono'){
		$actualizar = $this->db->set('telefono',$valor)->where('ID',$id)->update('publicadores');
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

function req_datos_publicadores($pagina){
	$tamaño_pagina = 10;
	$publicadores  = $this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta')->join('territorios','territorios.ID_publicador = publicadores.ID  or territorios.ID_publicador_campaing = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->get('publicadores');
	$numero_filas  = $publicadores->num_rows();
	$total_paginas = ceil($numero_filas/$tamaño_pagina);
	$empezar_desde = ($pagina-1)*$tamaño_pagina;
	$result_publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing')->join('territorios','territorios.ID_publicador = publicadores.ID or territorios.ID_publicador_campaing = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->get('publicadores',$tamaño_pagina,$empezar_desde);
	return ["total_paginas"=>$total_paginas,"publicadores"=>$result_publicadores->result_array()];
}

function info_user($id){
	$publicadores = $this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing')->join('territorios','territorios.ID_publicador = publicadores.ID or territorios.ID_publicador_campaing = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->where('publicadores.ID',$id)->get('publicadores');
	return $publicadores->result_array();
}

}