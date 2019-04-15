<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Territorios_model extends CI_Model{

	function add_territorio_model($numero_terri,$zona){
		if(empty($numero_terri) || empty($zona)){
			return false;
		}
		$zona=strtolower($zona);
		$comprobar_numero  = $this->db->select('territorios.numero_territorio,zona.zona')->join('zona', 'zona.ID_territorio = territorios.ID','left')->where('territorios.numero_territorio',$numero_terri)->where('territorios.ID_congregacion',$this->session->userdata['id_congregacion'])->get('territorios');
		$comprobar_numero = $comprobar_numero->row_array();
		if($comprobar_numero['numero_territorio'] == $numero_terri && $comprobar_numero['zona'] == $zona){
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

}
