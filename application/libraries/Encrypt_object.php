
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

	function encrypt_clave_validar($usuario,$id,$congregacion,$clave = 'jd1714hc1712.'){

			$key = $usuario.$id.$congregacion.$clave;
			$new_key = password_hash($key, PASSWORD_DEFAULT, array('cost' =>10));
			return $new_key;
	}
}
