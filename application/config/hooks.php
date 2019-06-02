<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
Este hooks protege las rutas para usuarios no logueados y tambien la ruta de registro ya que necesita una clave de invitacion para poder registrarse. La funcion funciona de la siguiente manera:

Si existe una sesion con un token --- $this->CI->session->userdata['token'] que entre en la condicional.

Ahora si ese token guardado en la variable `$valido` - el cual recogemos con la funcion get_token($this->CI->session->userdata['token']) una libreria creada por nosotros - es valido que nos reedirija al panel de control.

Si el token no es valido que destruya la sesion y reedirija al /login, asi evitaremos tokens invalidos y tokens caducados.

Si no existe la sesion con un token --- $this->CI->session->userdata['token'] que reedirija al /login peeero que tenga en cuenta que no estamos en la url 'registrarse' o el controlador 'Login_register/comprobarKey',

ya que hacia este ultimo controlador mandamos una peticion via ajax para comprobar la clave de invitacion y poder acceder a la pagina de registro por lo tanto las siguientes condicionales trabajn de la siguiente manera

if(uri_string()== 'registrarse' && !get_cookie('valid_register')){
			redirect('/login'); 
Si estamos en 'registrase'  y no existe la cookie('valid_register') que reedirija a /login

if(uri_string()!= 'registrarse' && !empty(get_cookie('valid_register'))){
				delete_cookie('valid_register');
			}
Si estamos en otra url y existe la cookie que la destruya ya que solo queremos generarla si la clave de seguriad que comprobamos en el controlador 'Login_register/comprobarKey' sea correcta.

Si la get_cookie('valid_register')  existe no reedirigira a ningun sitio y se quedara en la pagina registro
*/


$hook['post_controller'][]= function(){
	$this->CI=&get_instance();
	$this->CI->load->library('Sesion_token');
	if(!empty($this->CI->session->userdata['token'])){    
	$valido = $this->CI->sesion_token->get_token($this->CI->session->userdata['token']);
		if($valido && uri_string()== 'login' || $valido && uri_string()=='registrarse'){
			redirect('/');
		}elseif(!$valido){
			$this->CI->session->sess_destroy();
			redirect('/login');
		}
	}else{ 
		$this->CI->load->helper('cookie');
        if(uri_string()!='login' && uri_string()!='Login_register/login' && uri_string()!='registrarse' && uri_string()!='Login_register/comprobarKey' && uri_string()!='Login_register/registro'){
        	redirect('/login');
		}
		if(uri_string()== 'registrarse' && !get_cookie('valid_register')){
			redirect('/login');
		}
		if(uri_string()!= 'registrarse' && !empty(get_cookie('valid_register'))){
				delete_cookie('valid_register');
		}

	}
};
$hook['post_controller'][]=function(){
	$this->CI=&get_instance();
	if(!empty($this->CI->session->userdata['token'])){
		$fecha=$this->CI->db->select("ID,fecha_cierre")->where("ID_congregacion",$this->CI->session->userdata['id_congregacion'])->where("activo",1)->get("service_year");
		$fecha = $fecha->row_array();
		if($fecha["fecha_cierre"]<date("y-m-d")){
			$this->CI->db->trans_begin();
			$this->CI->db->set("activo",0)->where("ID_congregacion",$this->CI->session->userdata['id_congregacion'])->where("ID",$fecha['ID'])->update("service_year");
			$array_service_year=[
					"ID_congregacion" => $this->CI->session->userdata['id_congregacion'],
					"year"        	  => (date("y"))."-".(date("y")+1),
					"fecha_cierre"    => (date("y")+1)."-08-31",
					"activo"          => 1
				];
			$this->CI->db->insert('service_year',$array_service_year);
			$id_service_year = $this->CI->db->select("ID")->order_by('ID desc')->limit(1)->get('service_year');
			$id_service_year = $id_service_year->row_array();
			$territorios = $this->CI->db->select('ID')->where("ID_congregacion",$this->CI->session->userdata['id_congregacion'])->get("territorios");
			$numero = $territorios->num_rows();

			$array_datos=[
				"id_service_year" => $id_service_year['ID'],
				"numero_territorios" => $numero,
				"territorios_predicados" => 0
			];
			$this->CI->db->insert('datos_service_year',$array_datos);
			$territoriosinsert = $territorios->result_array();
			foreach ($territoriosinsert as $terrid) {
				$this->CI->db->insert('control_service_year',[ "id_service_year"   => $id_service_year['ID'],
			                                                       "ID_territorio" => $terrid["ID"],
			                                                       " predicado"    => 0 ]);
			                               
			}
			if ($this->CI->db->trans_status() === FALSE)
				{
				        $this->CI->db->trans_rollback();
				}
				else
				{
				        $this->CI->db->trans_commit();
				}
		}
	}
};