<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{

	/**Con esta funcion comprobamos si obtienen la clave de invitacion, si es correcta pueden continuar con el proceso de registro, si no sera rechazado ese proceso esta funcion se llama desde el controlador Login_register->comprobarKey()**/
		public function secret_key($key){
			$clave = $this->db->select("*")->get("secret_key");
			$clave = $clave->row_array();
			$this->load->library('Encrypt_object');
			if($valid = $this->encrypt_object->validar_password($key,$clave["secret_key"])){
				return true;
			}
			return false;
		}

		public function login($usuario,$password){
			$User_data = $this->db->select('administrador.ID,administrador.ID_congregacion,administrador.nombre,administrador.password,administrador.email,administrador.activo,congregaciones.nombre as nombre_congregacion')->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->where('nombre_usuario',$usuario)->or_where('email',$usuario)->get('administrador');
			if($User_data->num_rows()>0){
				$User_data = $User_data->row_array();
				$this->load->library('Encrypt_object');
				$acceso = $this->encrypt_object->validar_password($password,$User_data['password']);
				if($acceso){
					if($User_data['activo']){
						return $User_data;
					}else{
						return 'Necesitas activar tu cuenta, vaya a su correo electronico y compruebe el correo que le enviamos para activar su cuenta';
					} 
				}
				return false;
			}
			return false;
		}

		/***funcion para registrar al administrador y congregacion, esta funcion se llama desde el controlador login_register->registro()***/
		public function register($object,$pass){
			$this->db->trans_begin();
			$datos_array = (array) $object;
			/**validamos si los datos estan rellenos o son nulos**/

			foreach ($datos_array as $datos) {
				if(!$datos || $datos ===''){
					return false;
				}

			}
			/*si estan rellenos procedemos a a ingresar los datos en la base de datos*/
			/*comprobamos si existe email o usuario*/

			$comprovarexiste = $this->db->select('nombre_usuario','email')->where('nombre',$datos_array["nombreusuario"])->or_where('email',$datos_array["email"])->get('administrador');
			if($comprovarexiste->num_rows()>0){
				return $existe = 'El usuario o email ya existe por favor escoja otro';
			}
			/*si no existe email o usuario procedemos a ingresar en la base de datos*/

			$array_insert_congregacion = [
				"nombre"    => $datos_array['nombrecongregacion'],
				"provincia" => $datos_array['provincia'],
				"localidad" => $datos_array['localidad'],
			];

			$datos = $this->db->insert('congregaciones',$array_insert_congregacion);

			/**recogemos el ultimo dato ingresado de la congregacion**/
			$conseguir_id_congregacion = $this->db->select('id')->order_by('id desc')->limit(1)->get('congregaciones');
			$conseguir_id_congregacion = $conseguir_id_congregacion->row_array();

			/*ingresamos los datos del usuario con el id_congregacion*/

			$array_insert_administrador = [
				"ID_congregacion"    => $conseguir_id_congregacion['id'],
				"nombre"             => $datos_array['nombreadministrador'],
				"apellidos"          => $datos_array['apellidos'],
				"nombre_usuario"     => $datos_array['nombreusuario'],
				"email"              => $datos_array['email'],
				"password"			 => $pass
				];
			$this->db->insert('administrador',$array_insert_administrador);

			/*ingresamos a este administrador en la tabla publicadores ya ue es un publicador mas*/
			$admin_publicador = [
				"ID_congregacion"    => $conseguir_id_congregacion['id'],
				"nombre"             => $datos_array['nombreadministrador'],
				"apellidos"          => $datos_array['apellidos'],
				"email"              => $datos_array['email'],
			];
			$this->db->insert('publicadores',$admin_publicador);

			/**Ahora seleccionamos los datos del usuario que hemos ingresado con un left join para sacar el nombre de la congregacion**/
			$datos_user = $this->db->select('administrador.id,administrador.nombre,administrador.apellidos,administrador.email,congregaciones.nombre as nombre_congregacion')
				   ->join('congregaciones', 'congregaciones.ID = administrador.ID_congregacion','left')->order_by('id desc')->limit(1)->get('administrador');
			$datos_user = $datos_user->row_array();
			/**llamamos a la libreria de encryptacion y encriptamos la password de seguridad de validacion y procedemos a insertarla en la base de datos**/
			$this->load->library('Encrypt_object');
			$claveseguraencryp = $this->encrypt_object->encrypt_clave_validar($datos_user['nombre'],$datos_user['id'],$datos_user['nombre_congregacion']);
			$arra_clavesegura = [
				'ID_administrador' => $datos_user['id'],
				'claveaut'         => $claveseguraencryp
				];
			$this->db->insert('seguridad_validacion',$arra_clavesegura);
			if(date("m") == "09" || date("m") == "10" || date("m") == "11" || date("m") == "12"){
				$yearfinhis= date("y")+1;
				$year = date("y")."-".date("y")+1;
			}else{
				$yearfinhis= date("y");
				$year = (date("y")-1)."-".date("y");
			}
			$array_service_year=[
				"ID_congregacion" => $conseguir_id_congregacion['id'],
				"year"        	  => $year,
				"fecha_cierre"    => $yearfinhis."-08-31",
				"activo"          => 1
			];
		$this->db->insert('service_year',$array_service_year);
			if ($this->db->trans_status() === FALSE)
			{
			        $this->db->trans_rollback();
			}
			else
			{
			        $this->db->trans_commit();
			       return $datos_user;
			}
		}
		public function activate_account($key,$ID_admin){
			$select_key = $this->db->select('claveaut')->where('ID_administrador',$ID_admin)->get('seguridad_validacion');
			$select_key = $select_key->row_array();
			$this->load->library('Encrypt_object');
			if($this->encrypt_object->validar_password($key."jd1714hc1712.",$select_key['claveaut'])){
				$activar = $this->db->set('activo',1)->where('ID',$ID_admin)->update('administrador');
				return true;
			}
			return false;
		}
		/*function new_service_year(){
			if(date("m") == 09 || date("m") == 10 || date("m") == 11 || date("m") == 12){
				$yearfinhis= date("y")+1;
			}else{
				$yearfinhis= date("y");
			}
			if(date("m") == 09 || date("m") == 10 || date("m") == 11 || date("m") == 12){
				$year = date("y")."-".date("y")+1;
			}else{
				$year = date("y")-1."-".date("y");
			}
			$array_service_year=[
				"ID_congregacion" => $this->session->userdata['id_congregacion'],
				"year"        	  => $year,
				"fecha_cierre"    => $yearfinhis."-08-31",
				"activo"          => 1
			];
		$this->db->insert('service_year',$array_service_year);
		$id_service_year = $this->db->select("ID")->order_by('ID desc')->limit(1)->get('service_year');
		$id_service_year = $id_service_year->row_array();
		$territorios = $this->db->select('ID')->where("ID_congregacion",$this->session->userdata['id_congregacion'])->get("territorios");
		$numero = $territorios->num_rows();

		$array_datos=[
			"id_service_year" => $id_service_year['ID'],
			"numero_territorios" => $numero,
			"territorios_predicados" => 0
		];
		$this->db->insert('datos_service_year',$array_datos);
		$territoriosinsert = $territorios->result_array();
		foreach ($territoriosinsert as $terrid) {
			$this->db->insert('control_service_year',[ "id_service_year"   => $id_service_year['ID'],
		                                                       "ID_territorio" => $terrid["ID"],
		                                                       " predicado"    => 0
		                                                     ]);
		}
		}*/

}

?>