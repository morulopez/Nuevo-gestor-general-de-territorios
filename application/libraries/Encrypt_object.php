
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encrypt_object{

	function encryptpass($pass, $passvalid){
		if(empty($pass) || empty($passvalid) || $pass!=$passvalid){
			return false;
		}
		$pass_cifrado = password_hash($pass, PASSWORD_DEFAULT, array('cost' =>10));
		return $pass_cifrado;
	}
	/** esta funcion encripta la clave que creamos para la seguridad de la activacion de la cuenta, se llama desde el modelo Login_model.php antes de ingresarla en la base de datos**/
	function encrypt_clave_validar($usuario,$id,$congregacion,$clave = 'jd1714hc1712.'){

			$key = $usuario.$id.$congregacion.$clave;
			$new_key = password_hash($key, PASSWORD_DEFAULT, array('cost' =>10));
			return $new_key;
	}
	/**Usamos esta libreria para validar las password encryptadas, lo llamamos desde el modelo Login_model.php, con ella validamos la clave para poder registrarnos en la funcion de este modelo secret_key(), tambien la llamamos desde la funcion de este modelo login()**/
	function validar_password($password,$passwordencryp){
		if(password_verify($password, $passwordencryp)){
			return true;
		}
		return false;
	}
}
