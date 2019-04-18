<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($datos_territorio);
?>
<script>
	let ReqDatosTerri = new territorios('<?php echo URL; ?>','<?php echo $id;?>','<?php echo $this->uri->segment(2); ?>');
</script>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata">
		<div class="primerainfo">
			<div class="row">
				<div class="col-md-4 text-left">
					<span class="infoterri1">Territorio numero:</span><span class="infoterri"><?php echo $datos_territorio[0]['numero_territorio'];?></span>
				</div>
				<div class="col-md-4 text-left">
					<span class="infoterri1">Zona:</span> <span class="infoterri"><?php echo $datos_territorio[0]['zona'];?></span>
				</div>
			</div>
			<div class="row">
					<?php if($datos_territorio[0]['asignado']){ ?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de servicio asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Publicador:</span><span class="infoterri"><?php echo $datos_territorio[0]['nombre']." ". $datos_territorio[0]['apellidos'];?></span>
					</div>
					<?php }else{ ?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de servicio asignado:</span><span class="infoterri">NO</span>
					</div>
					<?php } ?>
			</div>
			<div class="row">
					<?php if($datos_territorio[0]['asignado_campaing'] AND $datos_territorio[0]['asignado']==NULL){?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Publicador:</span><span class="infoterri"><?php echo $datos_territorio[0]['nombre']." ". $datos_territorio[0]['apellidos'];?></span>
					</div>
					<?php }?>
			</div>
			<div class="row">
					<?php if($datos_territorio[0]['asignado_campaing'] AND $datos_territorio[0]['asignado']){?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
					<?php if(!empty($datos_territorio[1]['nombre'])){
						echo '<span class="infoterri1">Publicador:</span><span class="infoterri"> '.$datos_territorio[1]["nombre"].' '.$datos_territorio[1]["apellidos"].'</span>';
						}else{
						echo '<span class="infoterri1">Publicador:</span><span class="infoterri">'.$datos_territorio[0]["nombre"].' '.$datos_territorio[0]["apellidos"].'</span>';
						}
					}?>
					</div>
					<?php if($datos_territorio[0]['asignado_campaing']==NULL){?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">NO</span>
					</div>
					<?php } ?>
			</div>
		</div>
		<div class="row">
			<?php if(!empty($datos_territorio[0]['imagen'])){
					echo '<div class="col-md-4 text-left">
							<span class="infoterri1">Imagen del territorio:</span>
						  </div>
						  <div class="col-md-6 text-left divimg">
						    <div class="marcoimg">
						    	<img src="'.$datos_territorio[0]["imagen"].'" style="width: 100%">
						    </div>
					      </div>';
			}else{
				echo '
				<div class="col-md-4 text-left">
							<span class="infoterri1">Sin imagen:</span>
				</div>
				<div class="col-md-4 text-left">
					<i class="fas fa-times-circle"></i>
					<input type="file" class="inputfile" id="contefileifntoterri" aria-describedby="emailHelp">
					<button type="button" class="botonimag" onclick="ReqDatosTerri.activarFile();"><i class="fas fa-images"></i>Subir Imagen</button><span id="nombreimg"></span>
				</div>';
			}?>
		</div>
	<div class="row">
		<div class="col-md-8 showbutton text-left">
			<button type="button" class="btn btn-outline-primary showobser" onclick="ReqDatosTerri.mostrar('observaciones');">Ver observaciones</button>
			<button type="button" class="btn btn-primary createobser" onclick="ReqDatosTerri.mostrar('crearobservaciones');">Crear observacion</button>
			<button type="button" class="btn btn-outline-primary showhistorial" onclick="ReqDatosTerri.mostrar('historial');">Ver historial</button>
		</div>
	</div>
	</div>
</div>
<div class="lineaobservaciones" id="observaciones">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10 infoboxdata">
			<div class="row">
				<div class="col-md-12 text-right">
					<i class="fas fa-times-circle circlecerrar" onclick="ReqDatosTerri.cerrarventana('observaciones')"></i>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-left">
					<?php 
					$observe=true;
					foreach ($datos_territorio as $territorios ) {
						if($territorios['observacion']){
							echo "<div class='row'>
								    <div class='col-md-6 divobservaciones'>
								    	{$territorios['observacion']}
								    </div>
								    <div class='col-md-2 divobservaciones'>
								    	Creada: {$territorios['creado']}
								    </div>
								    <div class='col-md-3 '>
								    	<button type='button' onclick='ReqDatosTerri.borrarObservacion({$territorios['ID']},{$territorios['idobservaciones']})' class='btn btn-warning botonbaja'><i class='fas fa-trash'></i>Borrar observacion</button>
								    </div>
							</div>";
					    }else{
					    	if($observe){
						    	echo "<div class='row'>
						    		<div class='col-md-12 text-center'>
						    			<h5>Sin observaciones</h5>
						    		</div>
						    	</div>";
					        }
					    }
					    $observe=false;
					}?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="lineacrearobservaciones" id="crearobservaciones">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10 infoboxdata">
			<div class="row">
				<div class="col-md-12 text-right">
					<i class="fas fa-times-circle circlecerrar" onclick="ReqDatosTerri.cerrarventana('crearobservaciones')"></i>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 text-left">
					<form id="formularioobservacion">
						<div class="form-group">
							<textarea id="infoobservacion" placeholder="Escribe una observacion..."></textarea><br>
							<div class="text-right">
								<button type="button" class="btn btn-outline-primary showobser" onclick="ReqDatosTerri.crearobservacion()">Crear observacion</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>