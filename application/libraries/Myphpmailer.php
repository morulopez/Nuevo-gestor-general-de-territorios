<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');

class Myphpmailer {

	function __construct(){}
	
	function email_validacion_cuenta($email,$id_usuario,$nombre,$apellidos,$congregacion){
		$mail = new PHPMailer(true);

		try {
		    $mail->SMTPDebug = 2;                                                                       
		    $mail->Host      = 'localhost'; 
		    $mail->setFrom('jesuslopezprogramador@gmail.com');
		    $mail->addAddress($email);
		    $mail->isHTML(true);
		    $mail->Subject   = 'PRUEBA DESDE CODEIGNITER';
		    $mail->Body      = '<!DOCTYPE html>
								<html>
									<head>
										<meta charset="utf-8">
									    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
										<title>Confrimaciondecuenta</title>
										<style>
										.botonemail{
											padding:10px;
											background-color: #fff;
											border: 1px solid #a500f2;
											color:#a500f2;
											cursor: pointer;
											padding: 5px;
											border-radius:5px;
										}
										.botonemail:hover{
											background-color:#a500f2;
											color:#fff;
											border: 1px solid #a500f2;
										}
										.general{
											display:flex;
											margin:50px;
										}
										.izq{
											padding:10px;
											width:40%;
											background-color:#fcfdff;
											height:400px;
										}
										.titulo{
											text-align:center;
											margin-top: 20px;
										}
										.parrafo{
											margin-top: 60px;
										}
										.boton{
											text-align:center;
											margin-top: 40px;
										}
										.der{
											width:40%;
											background-image: url("http://localhost/territoriosCodeigniter/CDN/images/imagen_correo.jpg");
											background-size:cover;            
											background-position:center;      
											background-blend-mode:  soft-light;
											overflow: hidden;
											height:400px;
										}
										h3{
											color:#123e84;
										}

										</style>
									</head>
									<body>
										<div class="general">
											<div class="izq">
											    <div class="titulo">
													<h3>Gracias por subscribirte y bienvenido!</h3>
												</div>
												<div class="parrafo">
													<p>Hola '.ucwords($nombre).' '.ucwords($apellidos).'.
													Te has registrado como administrador de la congregacion <strong>'.ucwords($congregacion).'</strong>.<br>
													Espero que disfrutes de este software y le saques el maximo partido.
													Activa tu cuenta para poder utilizar el programa.
													</p>
												</div>
												<div class="boton">
													<a href="'.site_url("Inicio_territorios/activacion/".$nombre."-".$id_usuario."-".$congregacion).'"><button type="button" class="botonemail">Activar</button></a>
												</div>
											</div>
											<div class="der">
											</div>
										</div>
									</body>
								</html>';
		    $mail->AltBody   = 'Gracias por subscribirte
										Bienvenido '.ucwords($nombre).' '.ucwords($apellidos).'.
										Te has registrado como administrador de la congregación <strong>'.ucwords($congregacion).'</strong>
										Activa tu cuenta para poder utilizar el programa.<a href="'.site_url("Inicio_territorios/activacion/".$nombre."-".$id_usuario."-".$congregacion).'">Pulsar</a>';

		    $mail->send();
		    return true;
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

}
