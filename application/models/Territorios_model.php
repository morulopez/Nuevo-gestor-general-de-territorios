<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Territorios_model extends CI_Model{

	function add_territorio_model($numero_terri,$zona){
		if(empty($numero_terri) || empty($zona)){
			return false;
		}
		$zona=strtolower($zona);
		$comprobar_numero  = $this->db->select('territorios.numero_territorio,zona.zona')->join('zona', 'zona.ID_territorio = territorios.ID','left')->where('territorios.numero_territorio',$numero_terri)->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->where('zona.zona',$zona)->get('territorios');
		if($comprobar_numero->num_rows()>0){
			return 'Este numero de territorio ya tiene esta zona asignada, cambia el numero o la zona por favor';
		}
		$territorio      = ['ID_congregacion'=>$this->session->userdata['id_congregacion'],
	                        'numero_territorio'=> $numero_terri];
	    $territorios     = $this->db->set($territorio)->insert('territorios');
	    $dato_territorio = $this->db->select('ID')->order_by('ID desc')->limit(1)->get('territorios');

	    $id_territorio   = $dato_territorio->row_array();
	    $comprobar_zona  = $this->db->select('ID_territorio,zona')->where('ID_territorio',$id_territorio['ID'])->where('zona',$zona)->get('zona');
	    $zona_terri            = ['id_territorio' => $id_territorio['ID'],
	                        'zona'          => $zona];
	                        $this->db->set($zona_terri)->insert('zona');

	    $campaing=$this->comprobar_campaing();
	    if($campaing){
	    	$this->actualizar_datos_campaing($id_territorio['ID'],$campaing['ID']);
	    }
	    return $id_territorio['ID'];

	}
	/**Esta funcion es por si despues decrear una campaña insertan territorios nuevos.Para que la camapaña obtenga todos los territorios insertamos el territorio ultimo creado AQUI COMPROBAMOS LA CAMPAÑA**/
	private function comprobar_campaing(){
		$camaping =$this->db->select('ID')->where('activa',1)->where('ID_congregacion',$this->session->userdata['id_congregacion'])->get('campaing');
		if($camaping->num_rows()>0){
			return $camaping->row_array();
		}
		return false;
	}
	/**Esta funcion es por si despues decrear una campaña insertan territorios nuevos.Para que la camapaña obtenga todos los territorios insertamos el territorio ultimo creado AQUI ACTUALIZAMOS LA CAMPAÑA**/
	private function actualizar_datos_campaing($id_territorio,$id){
		$numeroterritorios = $this->db->select('numero_territorios')->where('ID_campaing',$id)->get('datos_campaing');
		$numeroterritorios=$numeroterritorios->row_array();
		$this->db->set("numero_territorios",$numeroterritorios['numero_territorios']+1)->where("ID_campaing",$id)->update('datos_campaing');
		$this->db->insert("control_territorios_campaing",["ID_campaing"   => $id,
	                                                      "ID_territorio" => $id_territorio,
	                                                      "predicado"     => 0]);
		return true;
	}
	/**Esta funcion es por si despues decrear una campaña insertan territorios nuevos.Para que la camapaña obtenga todos los territorios insertamos el territorio ultimo creado AQUI ACTUALIZAMOS LA CAMPAÑA SI SE BORRAA UN TERRITORIO**/
	private function actualizar_datos_campaing_from_delete($id_territorio,$id){
		$numeroterritorios = $this->db->select('numero_territorios')->where('ID_campaing',$id)->get('datos_campaing');
		$numeroterritorios=$numeroterritorios->row_array();
		$this->db->set('numero_territorios',$numeroterritorios['numero_territorios']-1)->where("ID_campaing",$id)->update('datos_campaing');
		$this->db->where('ID_campaing',$id)->where('ID_territorio',$id_territorio)->delete('control_territorios_campaing');
		return true;
	}
	/**Funcion para añadir imagen a un territorio cuando se crea**/
	function add_img_model($img,$id,$idcloud){
		$array = [
			'imagen'  => $img,
			'id_cloud'=> $idcloud
		];
		$img = $this->db->set($array)->where('ID',$id)->update('territorios');
		return $img;

	}
	/**Con esta funcion actualizamos la imagen de un territorio creado**/
	function update_img_model($id_territorio,$archivo){
		$this->load->library('Cloud_image');
		$imagen = $this->db->select('id_cloud')->where('ID',$id_territorio)->get('territorios');
		$imagen = $imagen->row_array();
		$this->cloud_image->borrar_img($imagen['id_cloud']);
		$img    = $this->cloud_image->subir_imagen($archivo,$this->session->userdata['id_congregacion'],$this->session->userdata['nombre_congregacion']);
		$array = [
			"imagen"   => $img['secure_url'],
			"id_cloud" => $img['public_id']
		];
		$update = $this->db->set($array)->where('ID',$id_territorio)->update('territorios');
		return $update;
	}
	/**Recogemos los datos de los territorios via ajax para mostrarlos**/
	function req_datos_territorios($pagina){
		$tamaño_pagina = 10;
		$territorios  = $this->db->select('territorios.id,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,zona.zona')->join('zona','zona.ID_territorio = territorios.ID','left')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->get('territorios');
		$numero_filas  = $territorios->num_rows();
		$total_paginas = ceil($numero_filas/$tamaño_pagina);
		$empezar_desde = ($pagina-1)*$tamaño_pagina;
		$result_territorios=$this->db->select('territorios.id,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,zona.zona')->join('zona','zona.ID_territorio = territorios.ID','left')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->order_by('zona asc')->order_by('numero_territorio asc')->get('territorios',$tamaño_pagina,$empezar_desde);
		return ["total_paginas"=>$total_paginas,"territorios"=>$result_territorios->result_array()];
	}
	function info_territorio($id){
		$territorio = $this->db->select('territorios.ID,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.imagen,territorios.entrega,territorios.devuelta,territorios.entrega_campaing,territorios.devuelta_campaing,zona.zona,publicadores.nombre,publicadores.apellidos')->join('zona', 'zona.ID_territorio = territorios.ID','left')->join('publicadores','publicadores.ID = territorios.ID_publicador or  publicadores.ID = territorios.ID_publicador_campaing','left')->where('territorios.ID',$id)->get('territorios');
		$territorio = $territorio->result_array();
		$observaciones = $this->db->select('ID,observacion,creado')->where('ID_territorio',$id)->get('observaciones');
		$observaciones = $observaciones->result_array();
		$historial = $this->db->select('ID,obser_historial,creado')->where('ID_territorio',$id)->get('historial');
		$historial = $historial->result_array();
		return ["territorios"  => $territorio,
	            "observaciones" => $observaciones,
	            "historial"     => $historial
	            ];
	}
	function borrar_observacion($id){
		$delete=$this->db->where('ID', $id)->delete('observaciones');
		return $delete;
	}
	function crear_observacion($id_terri,$observacion,$fecha){
		$array = [
			"ID_territorio"  => $id_terri,
			"observacion"    => $observacion,
			"creado"         => $fecha
		];
		$observacion = $this->db->insert('observaciones',$array);
		return $observacion;
	}
	function eliminar_territorio($id){
		$territorio = $this->db->select('id_cloud')->where('ID',$id)->get('territorios');
		$territorio = $territorio->row_array();
		if($territorio['id_cloud']!=NULL){
			$this->load->library('Cloud_image');
			$this->cloud_image->borrar_img($territorio['id_cloud']);
		}
		$delete = $this->db->where('ID',$id)->delete('territorios');
		$campaing=$this->comprobar_campaing();
	    if($campaing){
	    	$this->actualizar_datos_campaing_from_delete($id,$campaing['ID']);
	    }
		return $delete;
	}
	function req_terri_asigservicio(){
		$territorio = $this->db->select('territorios.ID,territorios.numero_territorio,zona.zona')->join('zona','zona.ID_territorio = territorios.ID','left')->order_by('trabajado_vezultima','acs')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->where('asignado','0')->get('territorios');
		return $territorios = $territorio->result_array();
	}
	function req_terri_asigscamaping($id){
		$territorio = $this->db->select('territorios.ID,territorios.numero_territorio,zona.zona,control_territorios_campaing.ID_territorio,control_territorios_campaing.predicado')->join('zona','zona.ID_territorio = territorios.ID','left')->join('control_territorios_campaing','control_territorios_campaing.ID_territorio = territorios.ID','left')->order_by('trabajado_vezultima','acs')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->where('asignado_campaing','0')->where('control_territorios_campaing.predicado',0)->where('control_territorios_campaing.ID_campaing',$id)->get('territorios');
		return $territorios = $territorio->result_array();
	}
	function obser_asig($id){
		$observaciones = $this->db->select('observacion')->where('ID_territorio',$id)->get('observaciones');
		if($observaciones->num_rows()>0){
			return $observaciones->result_array();
		}else{
			return "No hay resultados";
		}
	}
	function actualizar($info){
		if(empty($info->id) || empty($info->numero_terri) || empty($info->zona)){
			return "No puede haber ningun campo vacio";
		}
		$comprobar = $this->db->select('territorios.numero_territorio,zona.zona')->join('zona','zona.ID_territorio = territorios.ID ','left')->where('territorios.numero_territorio',$info->numero_terri)->where('zona.zona',$info->zona)->get('territorios');
		$comparar = $comprobar->row_array();
		$linea    = $comprobar->num_rows();
		if($comprobar->num_rows()>0){
			return 'El numero de territorio y zona ya existe';
		}
		$this->db->set('zona',$info->zona)->where('ID_territorio',$info->id)->update('zona');
		$this->db->set('numero_territorio',$info->numero_terri)->where('ID',$info->id)->update('territorios');
		return true;
	}
	function buscar_terri($value){
		$territorios=$this->db->select("territorios.ID,territorios.numero_territorio,observaciones.observacion,zona.zona")->join("observaciones","observaciones.ID_territorio = territorios.ID","left")->join("zona","zona.ID_territorio = territorios.ID","left")->where("territorios.asignado",0)->like('observaciones.observacion',$value)->get("territorios");
		return $territorios->result_array();
	}


}
