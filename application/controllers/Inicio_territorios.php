<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_territorios extends CI_Controller {

	public function index(){

	}
	function Inicio(){
		$html=$this->load->view("theme/mi_perfil.php",["id" => $this->session->userdata['id'],],true);
		$this->load->view("panel.php",["nombre_usuario" => $this->session->userdata['nombre'],
	                                   "congregacion"   => $this->session->userdata['nombre_congregacion'],
	                                   "contenido"      => $html]);
	}

	function Login(){
		$this->load->view("login.php");
	}
	function cerrar_sesion(){
		$this->session->sess_destroy();
		redirect('login');
	}

	function pagina_registro(){
		$this->load->view("registro.php");
	}
	function activacion($key){
		$clave=explode("-",$key);
		$claveString="";
		foreach($clave as $clave2){
			$claveString.=$clave2;
		}
		$this->load->model('Login_model');
		$data = $this->Login_model->activate_account($claveString,$clave[1]);
		redirect('/login');	
	}
	function territorios(){
		$html=$this->load->view('theme/territorios.php',["id" => $this->session->userdata['id']],true);
		$this->load->view('panel.php',[
			"nombre_usuario" => $this->session->userdata['nombre'],
	         "congregacion"  => $this->session->userdata['nombre_congregacion'],
			"contenido"      => $html]);
	}
	function pruebas(){
		/*$pru=$this->db->query("UPDATE datos_service_year SET numero_territorios = numero_territorios -1 WHERE ID = 7 ");/*$this->db->select("(territorios_predicados)-5 as territoriospredi")->where("ID",7)->get("datos_service_year");*/
		/*$pru=$pru->result_array();
		print_r($pru);*/
		/*$pru=$this->db->set("numero_territorios","numero_territorios -1",FALSE)->where("ID",7)->update("datos_service_year");
		}*/
		/*$User_data = $this->db->select('administrador.nombre,administrador.email,administrador.apellidos,congregaciones.nombre as nombre_congregacion,congregaciones.provincia,congregaciones.localidad')->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->where('administrador.ID',6)->get('administrador');
	$User_data = $User_data->row_array();
	$years_services = $this->db->select("ID,year,activo")->where("ID_congregacion",$this->session->userdata['id_congregacion'])->order_by("fecha_cierre desc")->get("service_year");
	$years_services = $years_services->row_array();
	$data = [
		"userdata" => $User_data,
		"years_services" => $years_services
	];
	$dato=json_encode($data);
	$dato = json_decode($dato);
	print_r($dato);
	echo $dato->userdata->nombre;*/
	$this->load->library('Mpdf');
	$html = $this->load->view('prueba.php',[],true);
	$this->mpdf->pdf($html);
	}
}

