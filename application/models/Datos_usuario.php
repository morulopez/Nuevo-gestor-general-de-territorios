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
	$tamaño_pagina = 30;
	$publicadores  = $this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta')->join('territorios','territorios.ID_publicador = publicadores.ID  or territorios.ID_publicador_campaing = publicadores.ID','left')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->get('publicadores');
	$numero_filas  = $publicadores->num_rows();
	$total_paginas = ceil($numero_filas/$tamaño_pagina);
	$empezar_desde = ($pagina-1)*$tamaño_pagina;
	$result_publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing')->join('territorios','territorios.ID_publicador = publicadores.id AND  territorios.ID_publicador_campaing = publicadores.id OR territorios.ID_publicador = publicadores.id OR territorios.ID_publicador_campaing = publicadores.id','left')->order_by('publicadores.nombre','asc')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->get('publicadores',$tamaño_pagina,$empezar_desde);
	return ["total_paginas"=>$total_paginas,"publicadores"=>$result_publicadores->result_array()];
}

function info_user($id){
	$publicadores = $this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.ID as idterritorios,territorios.devuelta,territorios.imagen,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing,zona.zona')->join('territorios','territorios.ID_publicador = publicadores.ID or territorios.ID_publicador_campaing = publicadores.ID','left')->join('zona', 'zona.ID_territorio = territorios.ID','left')->group_by('territorios.asignado')->group_by('territorios.asignado_campaing')->group_by('territorios.numero_territorio')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->where('publicadores.ID',$id)->get('publicadores');
	return $publicadores->result_array();
}
function asignarterritorio($data){
	if($data->tipo == "servicio"){
		$array=[ "ID_publicador" =>$data->id_publicador,
	             "entrega"       =>$data->entrega,
	             "devuelta"      =>$data->devuelta,
	             "asignado"      =>1 ];
	return $asignado = $this->db->set($array)->where('ID',$data->idterri)->update('territorios');
	}elseif($data->tipo == "campaing"){
		$array=[ "ID_publicador"          =>$data->id_publicador,
	             "entrega_campaing"       =>$data->entrega,
	             "devuelta_campaing"      =>$data->devuelta,
	             "asignado_campaing"      =>1 ];
	return $asignado = $this->db->set($array)->where('ID',$data->idterri)->update('territorios');
	}
}
function devolver_terri_servicio($data){
	$datos_publicador=$this->db->select('nombre,apellidos')->where('ID',$data->idpublicador)->get('publicadores');
	$datos_publicador = $datos_publicador->row_array();
	$datos_terri=$this->db->select('entrega')->where('ID',$data->idterritorio)->get('territorios');
	$datos_terri = $datos_terri->row_array();
	$this->load->library('Trabajar_fecha');
	$entrega = $this->trabajar_fecha->darvuelta($datos_terri['entrega']);
	$year= getdate();
	$fechahoy = date('d-m')."-".$year["year"];
	$array=[
		"ID_territorio"   => $data->idterritorio,
		"obser_historial" => "El territorio numero:{$data->numero_territorio} con zona en {$data->zona} lo ha trabajo el hermano {$datos_publicador['nombre']} {$datos_publicador['apellidos']} desde su entrega <strong>{$entrega}</strong> hasta el dia de devolucion <strong>{$fechahoy}</strong>",
		"creado" => date('d-m')."-".$year["year"]
	];
	$this->db->set($array)->insert('historial');
	$array_terri=[
		"ID_publicador" => NULL,
		"entrega"  => NULL,
		"devuelta" => NULL,
		"asignado" => 0,
		"trabajado_vezultima" =>"20".date('y-d-m')
	];
	$devuelto = $this->db->set($array_terri)->where("ID",$data->idterritorio)->update("territorios");
	return $devuelto;
}
function eliminarusuario($id){
	$delete = $this->db->where("ID",$id)->delete("publicadores");
	return $delete;
}

}