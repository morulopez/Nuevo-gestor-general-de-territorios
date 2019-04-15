<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'cloudinary_php/autoload.php';
//require_once('cloudinary_php/Helpers.php');
require_once('secretcloud/secretkey.php');

class Cloud_image{
	function __construct(){
		\Cloudinary::config(secret());
	}
	function subir_imagen($imagen,$id,$nombre_congre){
		$var=\Cloudinary\Uploader::upload($imagen, 
		   array (
		     "folder"    => "congregacion_".$nombre_congre."_".$id, 
		 	 "width"     => 350, 
		 	 "height"    => 250));
		return $var;
	}
	function borrar_img($id){
		return $img=\Cloudinary\Uploader::destroy($id);
	}
}
