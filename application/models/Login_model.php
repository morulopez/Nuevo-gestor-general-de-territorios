<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

	/**Con esta funcion comprobamos si obtienen la clave de invitacio, si es correcta pueden continuar con el proceso de registro, si no sera rechazado ese proceso esta funcion se llama desde el controlador Login_register->comprobarKey()**/
		public function secret_key($key){

			$clave = $this->db->select("*")->get("secret_key");
			$clave = $clave->row_array();
			if(password_verify($key,$clave["secret_key"])){
				return true;
			}
			return false;
		}
		/***funcion para registrar al administrador y congregacion esta funcion se llama desde el controlador login_register->registro()***/
		public function register($object,$pass){

			$datos_array = (array) $object;
			/**validamos si los datos estan rellenos o son nulos**/
			foreach ($datos_array as $datos) {
				if(!$datos || $datos ===''){
					return false;
				}

			}
			$comprovarexiste = $this->db->select('nombre_usuario','email')->where('nombre',$datos_array["nombreusuario"])->or_where('email',$datos_array["email"])->get('administrador');
			if($comprovarexiste->num_rows()>0){
				return $existe = 'El usuario o email ya existe por favor escoja otro';
			}
			$array_insert_congregacion = [
				"nombre"    => $datos_array['nombrecongregacion'],
				"provincia" => $datos_array['provincia'],
				"localidad" => $datos_array['localidad'],
			];
			$datos = $this->db->insert('congregaciones',$array_insert_congregacion);
				$conseguir_id_congregacion = $this->db->select('id')->order_by('id')->limit(1)->get('congregaciones');
				$conseguir_id_congregacion = $conseguir_id_congregacion->row_array();
				$array_insert_administrador = [
				"ID_congregacion"    => $conseguir_id_congregacion['id'],
				"nombre"             => $datos_array['nombreadministrador'],
				"apellidos"          => $datos_array['apellidos'],
				"nombre_usuario"     => $datos_array['nombreusuario'],
				"email"              => $datos_array['email'],
				"password"			 => $pass
				];
				$this->db->insert('administrador',$array_insert_administrador);
				$datos_user = $this->db->select('administrador.id,administrador.nombre,administrador.apellidos,administrador.email,congregaciones.nombre as nombre_congregacion')
				   ->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->order_by('id')->limit(1)->get('administrador');
				$datos_user = $datos_user->row_array();
				$this->load->library('Encrypt_object');
				$claveseguraencryp = $this->encrypt_object->encrypt_clave_validar($datos_user['nombre'],$datos_user['id'],$datos_user['nombre_congregacion']);
				$arra_clavesegura = [
					'ID_administrador' => $datos_user['id'],
					'claveaut'         => $claveseguraencryp
				];
				$this->db->insert('seguridad_validacion',$arra_clavesegura);

				return $datos_user;

		}

}

?>