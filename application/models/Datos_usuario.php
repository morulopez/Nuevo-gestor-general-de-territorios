<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_usuario extends CI_Model{


function data_user($id){
	$User_data = $this->db->select('administrador.nombre,administrador.email,administrador.apellidos,congregaciones.nombre as nombre_congregacion,congregaciones.provincia,congregaciones.localidad')->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->where('administrador.ID',$id)->get('administrador');
	return $User_data = $User_data->row_array();
}






}