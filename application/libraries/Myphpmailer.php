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
										<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
									</head>
									<body>
										<div class="row">
										<div class="col-md-4">
										</div>
										<div class="col-md-4">
											<h3>Gracias por subscribirte y bienvenido!</h3>
											<p>Hola '.ucwords($nombre).' '.ucwords($apellidos).'.
											Te has registrado como administrador de la congregacion <strong>'.ucwords($congregacion).'</strong>
											Activa tu cuenta para poder utilizar el programa.</p>
											<a href="http://localhost/territoriosCodeigniter/index.php/Inicio_territorios/activacion?data="'.$nombre.'"-"'.$id_usuario.'"-"'.$congregacion.'"><button type="button" class="botonemail">Activar</button></a>
										</div>
										</div>
									</body>
								</html>';
		    $mail->AltBody   = 'Gracias por subscribirte
										Bienvenido '.ucwords($nombre).' '.ucwords($apellidos).'.
										Te has registrado como administrador de la congregación <strong>'.ucwords($congregacion).'</strong>
										Activa tu cuenta para poder utilizar el programa.<a href="http://localhost/territoriosCodeigniter/index.php/Inicio_territorios/activacion?data="'.$nombre.'"-"'.$id_usuario.'"-"'.$congregacion.'">Pulsar</a>';

		    $mail->send();
		    return true;
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

}
