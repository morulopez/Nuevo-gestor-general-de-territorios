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
	    return $id_territorio['ID'];

	}
	function add_img_model($img,$id,$idcloud){
		$array = [
			'imagen'  => $img,
			'id_cloud'=> $idcloud
		];
		$img = $this->db->set($array)->where('ID',$id)->update('territorios');
		return $img;

	}
	function req_datos_territorios($pagina){
		$tamaño_pagina = 10;
		$territorios  = $this->db->select('territorios.id,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,zona.zona')->join('zona','zona.ID_territorio = territorios.ID','left')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->get('territorios');
		$numero_filas  = $territorios->num_rows();
		$total_paginas = ceil($numero_filas/$tamaño_pagina);
		$empezar_desde = ($pagina-1)*$tamaño_pagina;
		$result_territorios=$this->db->select('territorios.id,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,zona.zona')->join('zona','zona.ID_territorio = territorios.ID','left')->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->order_by('numero_territorio asc')->order_by('zona asc')->get('territorios',$tamaño_pagina,$empezar_desde);
		return ["total_paginas"=>$total_paginas,"territorios"=>$result_territorios->result_array()];
	}
	function info_territorio($id){
		$territorio = $this->db->select('territorios.ID,territorios.numero_territorio,territorios.asignado,territorios.asignado_campaing,territorios.imagen,territorios.entrega,territorios.devuelta,territorios.entrega_campaing,territorios.devuelta_campaing,zona.zona,observaciones.ID as idobservaciones,observaciones.observacion,observaciones.creado,historial.ID as idhistorial,historial.obser_historial,historial.creado as historialcreado,publicadores.nombre,publicadores.apellidos')->join('zona', 'zona.ID_territorio = territorios.ID','left')->join('observaciones','observaciones.ID_territorio = territorios.ID','left')->join('historial','historial.ID_territorio = territorios.ID','left')->join('publicadores','publicadores.ID = territorios.ID_publicador or publicadores.ID = territorios.ID_publicador_campaing','left')->where('territorios.ID',$id)->get('territorios');
		$territorio = $territorio->result_array();
		return $territorio;
	}
	function borrar_observacion($id){
		$delete=$this->db->where('ID', $id)->delete('observaciones');
		return $delete;
	}

}
