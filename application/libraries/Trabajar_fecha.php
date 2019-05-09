<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trabajar_fecha{
	function darvuelta($fecha){
		if($fecha==NULL){
			return NULL;
		}
		$fecha = explode("-",$fecha);
		$meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$mes='';
		for($i=0;$i<=count($meses)-1;$i++){
			if($fecha[1]-1 == $i){
				$mes=$meses[$i];
				$nueva_fecha =$fecha[2]."-".$mes."-".$fecha[0];
				return $nueva_fecha;
			}
		}
	}
}
