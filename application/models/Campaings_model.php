<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaings_model extends CI_Model{
	
	function req_campaings(){
		$campaing = $this->db->select("ID,nombre_campaing,activa,fecha_apertura,fecha_cierre")->where("ID_congregacion",$this->session->userdata['id_congregacion'])->get("campaing");
		return $campaing->result_array();
	}
	function crear_campaing($data){
		$this->db->trans_begin();
		$array_campaing=[
			"ID_congregacion"        => $this->session->userdata['id_congregacion'],
			"nombre_campaing"        => $data->nombre,
			"activa"                 => 1,
			"fecha_apertura"         => $data->inicio,
			"fecha_cierre"           => $data->cierre,
			"observaciones_campaing" => $data->observaciones
		];
		$this->db->insert('campaing',$array_campaing);
		$id_campaing = $this->db->select("ID")->order_by('ID desc')->limit(1)->get('campaing');
		$id_campaing = $id_campaing->row_array();
		$territorios = $this->db->select('ID')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->get("territorios");
		$numero = $territorios->num_rows();

		$array_datos=[
			"ID_campaing" => $id_campaing['ID'],
			"numero_territorios" => $numero,
			"territorios_predicados" => 0
		];
		$this->db->insert('datos_campaing',$array_datos);
		$territoriosinsert = $territorios->result_array();
		foreach ($territoriosinsert as $terrid) {
			$this->db->insert('control_territorios_campaing',[ "ID_campaing"   => $id_campaing['ID'],
		                                                       "ID_territorio" => $terrid["ID"],
		                                                       " predicado"    => 0
		                                                     ]);
		}
		if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			}
			else
			{
			        $this->db->trans_commit();
			       return true;
			}
		
	}
	function req_campaings_info($id){
		$campaing_data = $this->db->select('campaing.ID,campaing.nombre_campaing,campaing.activa,campaing.fecha_apertura,campaing.fecha_cierre,campaing.observaciones_campaing,datos_campaing.numero_territorios,datos_campaing.territorios_predicados')->join('datos_campaing','datos_campaing.ID_campaing = campaing.ID','left')->where('campaing.ID',$id)->where("campaing.ID_congregacion",$this->session->userdata['id_congregacion'])->get('campaing');
		$campaing_data = $campaing_data->row_array();
		$control_campaing = $this->db->select('control_territorios_campaing.ID,control_territorios_campaing.predicado,territorios.numero_territorio,zona.zona,publicadores.nombre,publicadores.apellidos')->join('territorios','territorios.ID = control_territorios_campaing.ID_territorio',"left")->join('zona','zona.ID_territorio = territorios.ID','left')->join('publicadores','publicadores.ID = territorios.ID_publicador_campaing','left')->order_by('zona.zona asc')->order_by('territorios.numero_territorio asc')->where('control_territorios_campaing.ID_campaing',$id)->get('control_territorios_campaing');
		$control_campaing = $control_campaing->result_array();

		return ["datos"=>$campaing_data,"control"=>$control_campaing];

	}
	function req_campaing(){
		$campaing = $this->db->select('ID,nombre_campaing,activa')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->where("activa",1)->get("campaing");
		return $campaing->row_array();
	}
	function desactivar_campaing($id){
		$this->db->set("activa",0)->where("ID",$id)->update("campaing");
		return true;
	}
	function activar_campaing($id){
		$comprobar=$this->db->select('activa')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->where("activa",1)->get('campaing');
		if($comprobar->num_rows()>0){
			return "existe campaña";
		}
		$this->db->set("activa",1)->where("ID",$id)->update("campaing");
		return true;
	}
}
