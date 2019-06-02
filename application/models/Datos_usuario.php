<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_usuario extends CI_Model{


function data_user($id){
	$User_data = $this->db->select('administrador.nombre,administrador.email,administrador.apellidos,congregaciones.nombre as nombre_congregacion,congregaciones.provincia,congregaciones.localidad')->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->where('administrador.ID',$id)->get('administrador');
	$User_data = $User_data->row_array();
	$years_services = $this->db->select("ID,year,activo")->where("ID_congregacion",$this->session->userdata['id_congregacion'])->order_by("fecha_cierre desc")->get("service_year");
	$years_services = $years_services->result_array();
	return $data = [
		"userdata" => $User_data,
		"years_services" => $years_services
	];
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
	$publicadores = $this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.ID as idterritorios,territorios.devuelta,territorios.imagen,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing,territorios.id_service_year,zona.zona')->join('territorios','territorios.ID_publicador = publicadores.ID or territorios.ID_publicador_campaing = publicadores.ID','left')->join('zona', 'zona.ID_territorio = territorios.ID','left')->group_by('territorios.asignado')->group_by('territorios.asignado_campaing')->group_by('territorios.numero_territorio')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->where('publicadores.ID',$id)->get('publicadores');
	return $publicadores->result_array();
}
function asignarterritorio($data){
		$year_service_id = $this->db->select("ID")->where("activo",1)->where("ID_congregacion",$this->session->userdata['id_congregacion'])->get('service_year');
		$year_service_id = $year_service_id->row_array();
		$array=[ "ID_publicador" =>$data->id_publicador,
	             "entrega"       =>$data->entrega,
	             "devuelta"      =>$data->devuelta,
	             "asignado"      =>1,
	             "id_service_year" => $year_service_id['ID']
	         ];
	return $asignado = $this->db->set($array)->where('ID',$data->idterri)->update('territorios');
}
function asignarterritorio_campaing($data){
		$array=[ "ID_publicador_campaing" =>$data->id_publicador,
	             "entrega_campaing"       =>$data->entrega,
	             "devuelta_campaing"      =>$data->devuelta,
	             "asignado_campaing"      =>1 ];
	return $asignado = $this->db->set($array)->where('ID',$data->idterri)->update('territorios');
}
function devolver_terri_servicio($data){
	$this->db->trans_begin();
	$datos_publicador=$this->db->select('nombre,apellidos')->where('ID',$data->idpublicador)->get('publicadores');
	$datos_publicador = $datos_publicador->row_array();
	$datos_terri=$this->db->select('entrega')->where('ID',$data->idterritorio)->get('territorios');
	$datos_terri = $datos_terri->row_array();
	$this->load->library('Trabajar_fecha');
	$entrega = $this->trabajar_fecha->darvuelta($datos_terri['entrega']);
	$year= getdate();
	$fechahoy = $this->trabajar_fecha->darvuelta(date('d-m')."-".$year["year"]);
	$array=[
		"ID_territorio"   => $data->idterritorio,
		"obser_historial" => "Territorio numero: ".ucwords($data->numero_territorio)."<br>
		                      Zona: ".ucwords($data->zona)."<br>
		                      Trabajado por el hermano: ". ucwords($datos_publicador['nombre'])."
		".ucwords($datos_publicador['apellidos'])."<br>
		                      Entre las fechas: <strong>{$entrega}</strong> hasta el dia de devolucion <strong>{$fechahoy}</strong>",
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
	$idservice=$data->id_service_year;
	$devuelto = $this->db->set($array_terri)->where("ID",$data->idterritorio)->update("territorios");
	$terrinumber = $this->db->select("ID_territorio")->where("ID_service_year",$data->id_service_year)->where("predicado",0)->get("control_service_year");
	if($terrinumber->num_rows()>0){
		$this->db->set("territorios_predicados","territorios_predicados+1",FALSE)->where("ID_service_year",$data->id_service_year)->update("datos_service_year");
		$this->db->set("predicado",1)->where("id_service_year",$data->id_service_year)->where("ID_territorio",$data->idterritorio)->update("control_service_year");
	}
	if ($this->db->trans_status() === FALSE)
	{
	        $this->db->trans_rollback();
	}
	else
	{
	        $this->db->trans_commit();
	        return $devuelto;
	}
}
function devolver_territorio_campaing($data){
	$stored_procedure = "CALL devuelta_terri_campaing(?,?)";
	$this->db->query($stored_procedure,["id_campaing"=>$data->idcampaing,
                                        "id_territorio"=>$data->idterritorio]);
	return true;
}
function eliminarusuario($id){
	$delete = $this->db->where("ID",$id)->delete("publicadores");
	return $delete;
}
function buscar_publi($value){
	if(!empty($value->apellido)){
		$result_publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing')->join('territorios','territorios.ID_publicador = publicadores.id AND  territorios.ID_publicador_campaing = publicadores.id OR territorios.ID_publicador = publicadores.id OR territorios.ID_publicador_campaing = publicadores.id','left')->order_by('publicadores.nombre','asc')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->like('publicadores.nombre',$value->nombre)->like('publicadores.apellidos',$value->apellido)->or_like('publicadores.apellidos',$value->nombre)->or_like('publicadores.apellidos',$value->apellido)->get('publicadores');
		return $result_publicadores->result_array();
	}
		$result_publicadores=$this->db->select('publicadores.id,publicadores.nombre,publicadores.apellidos,publicadores.email,publicadores.telefono,territorios.devuelta,territorios.entrega,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.entrega_campaing,territorios.devuelta_campaing,territorios.ID_publicador,territorios.ID_publicador_campaing')->join('territorios','territorios.ID_publicador = publicadores.id AND  territorios.ID_publicador_campaing = publicadores.id OR territorios.ID_publicador = publicadores.id OR territorios.ID_publicador_campaing = publicadores.id','left')->order_by('publicadores.nombre','asc')->where('publicadores.ID_congregacion',$this->session->userdata['id_congregacion'])->like('publicadores.nombre',$value->nombre)->or_like('publicadores.apellidos',$value->nombre)->get('publicadores');
		return $result_publicadores->result_array();
}
function req_service_year(){
	$service_year = $this->db->select('ID')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->where("activo",1)->get("service_year");
		return $service_year->row_array();
}

function service_year_info($id){
		$service_data = $this->db->select('service_year.ID,service_year.year,service_year.activo,service_year.fecha_cierre,datos_service_year.numero_territorios,datos_service_year.territorios_predicados')->join('datos_service_year','datos_service_year.id_service_year = service_year.ID','left')->where('service_year.ID',$id)->where("service_year.ID_congregacion",$this->session->userdata['id_congregacion'])->get('service_year');
		$service_data = $service_data->row_array();
		$control_service = $this->db->select('control_service_year.ID,control_service_year.predicado,territorios.numero_territorio,zona.zona,publicadores.nombre,publicadores.apellidos')->join('territorios','territorios.ID = control_service_year.ID_territorio',"left")->join('zona','zona.ID_territorio = territorios.ID','left')->join('publicadores','publicadores.ID = territorios.ID_publicador','left')->order_by('zona.zona asc')->order_by('territorios.numero_territorio asc')->where('control_service_year.ID_service_year',$id)->get('control_service_year');
		$control_service = $control_service->result_array();

		return ["datos"=>$service_data,"control"=>$control_service,"numero_territorios"=>$service_data['numero_territorios'],"predicados"=>$service_data["territorios_predicados"]];

	}

}