<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = &get_instance();
$ci->load->library("Trabajar_fecha");
 $id_terri = $datos_territorio['territorios'][0]['ID'];
?>
<script src="<?php echo CDN;?>/JS/territorios.js"></script>
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
					<span class="infoterri1">Territorio numero:</span><span class="infoterri" id="numeroterri"><?php echo $datos_territorio['territorios'][0]['numero_territorio'];?></span>
				</div>
				<div class="col-md-4 text-left">
					<span class="infoterri1">Zona:</span> <span class="infoterri" id="spanzona"><?php echo $datos_territorio['territorios'][0]['zona'];?></span>
				</div>
				<div class="col-md-4 text-right">
					<span class="spanterriasig" id="spanerror2"></span>
					<i class="fas fa-eye-dropper editterri" id='iconoactualizar' title="editar territorio" onclick="ReqDatosTerri.actualizar_terri(<?php echo $id_terri;?>);"></i>
					<button type="button" style="display: none;margin-top: 5px;" id="botonactualizar" class="btn btn-outline-primary showobser botonesterri">Actualizar</button>
				</div>
			</div>
			<div class="row">
					<?php if($datos_territorio['territorios'][0]['asignado']){ ?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de servicio asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Publicador:</span><span class="infoterri"><?php echo $datos_territorio['territorios'][0]['nombre']." ". $datos_territorio['territorios'][0]['apellidos'];?></span>
					</div>
					<?php }else{ ?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de servicio asignado:</span><span class="infoterri">NO</span>
					</div>
					<div class="col-md-4 text-left">
					</div>
					<?php } ?>
			</div>
			<div class="row">
					<?php if($datos_territorio['territorios'][0]['asignado_campaing'] AND $datos_territorio['territorios'][0]['asignado']==NULL){?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Publicador:</span><span class="infoterri"><?php echo $datos_territorio['territorios'][0]['nombre']." ". $datos_territorio['territorios'][0]['apellidos'];?></span>
					</div>
					<?php }?>
			</div>
			<div class="row">
					<?php if($datos_territorio['territorios'][0]['asignado_campaing'] AND $datos_territorio['territorios'][0]['asignado']){?>
					<div class="col-md-4 text-left">
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">SI</span>
					</div>
					<div class="col-md-4 text-left">
					<?php if(!empty($datos_territorio['territorios'][1]['nombre'])){
						echo '<span class="infoterri1">Publicador:</span><span class="infoterri"> '.$datos_territorio['territorios'][1]["nombre"].' '.$datos_territorio['territorios'][1]["apellidos"].'</span>';
						}else{
						echo '<span class="infoterri1">Publicador:</span><span class="infoterri">'.$datos_territorio['territorios'][0]["nombre"].' '.$datos_territorio['territorios'][0]["apellidos"].'</span>';
						}?>
					</div>
					<?php }?>
					<div class="col-md-4 text-left">
					<?php if($datos_territorio['territorios'][0]['asignado_campaing']==NULL){?>
						<span class="infoterri1">Territorio de campaña asignado:</span><span class="infoterri">NO</span>
					<?php } ?>
				    </div>
			</div>
		</div>
		<div class="row">
			<?php if(!empty($datos_territorio['territorios'][0]['imagen'])){
					echo '<div class="col-md-4 text-left">
							<span class="infoterri1">Imagen del territorio:</span>
						  </div>
						  <div class="col-md-6 text-left">
						    <div class="marcoimg">
						    	<img src="'.$datos_territorio['territorios'][0]["imagen"].'" class="divimg" style="width: 100%;margin-bottom:10px;">
						    	<input type="file" class="inputfile" id="contefileinfoterri" aria-describedby="emailHelp">
								<button type="button" class="botonimag" onclick="ReqDatosTerri.activarFile(`contefileinfoterri`,`nameimg`,`button`)"><i class="fas fa-images"></i>Actualizar imagen</button><span id="nameimg"></span>
								<button type="button" class="subirimg" onclick="ReqDatosTerri.subirimg('.$id_terri.','.true.')">OK</button><button type="button" class="return">Volver</button><br>
					<span id="divcargaterritorios2"></span>
						    </div>
					      </div>';
			}else{
				echo '
				<div class="col-md-4 text-left">
							<span class="infoterri1">Sin imagen:</span>
				</div>
				<div class="col-md-4 text-left">
					<i class="fas fa-times-circle"></i>
					<input type="file" class="inputfile" id="contefileinfoterri" aria-describedby="emailHelp">
					<button type="button" class="botonimag" onclick="ReqDatosTerri.activarFile(`contefileinfoterri`,`nameimg`,`button`)"><i class="fas fa-images"></i>Subir Imagen</button><span id="nameimg"></span><button type="button" class="subirimg" onclick="ReqDatosTerri.subirimg('.$id_terri.')">OK</button><button type="button" class="return">Volver</button><br>
					<span id="divcargaterritorios2"></span>

				</div>';
			}?>
		</div>
		<div class="row">
			<div class="col-md-10 showbutton text-left">
				<button type="button" class="btn btn-outline-primary showobser botonesterri" onclick="ReqDatosTerri.mostrar('observaciones');">Ver observaciones</button>
				<button type="button" class="btn btn-primary createobser botonesterri" onclick="ReqDatosTerri.mostrar('crearobservaciones');">Crear observacion</button>
				<button type="button" class="btn btn-outline-primary showhistorial botonesterri" onclick="ReqDatosTerri.mostrar('historial');">Historial</button>
				<button type="button" title="eliminar territorio" class="btn btn-outline-primary botonbajater botonesterri" onclick="ReqDatosTerri.borrarterritorio(<?php echo $datos_territorio['territorios'][0]['ID'];?>,<?php echo $datos_territorio['territorios'][0]['asignado'];?>,<?php echo $datos_territorio['territorios'][0]['asignado_campaing'];?>)"><i class="fas fa-trash"></i></button>
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
					if(count($datos_territorio['observaciones'])<1){
						echo "<div class='row'>
						    		<div class='col-md-12 text-center'>
						    			<h5>Sin observaciones</h5>
						    		</div>
						    	</div>";
					}
					foreach ($datos_territorio['observaciones'] as $territorios ) {
						if($territorios['observacion']){
								echo "<div class='row'>
									    <div class='col-md-2 col-sm-4 col-lg-6 divobservaciones'>
									    	{$territorios['observacion']}
									    </div>
									    <div class='col-md-4 col-sm-6 col-lg-2 divobservaciones'>
									    	Creada:<span class='creacion'>".$ci->trabajar_fecha->darvuelta($territorios['creado'])."</span>
									    </div>
									    <div class='col-md-3 col-sm-2'>
									    	<button type='button' onclick='ReqDatosTerri.borrarObservacion({$id_terri},{$territorios['ID']})' class='btn btn-warning botonbaja botonesterri'><i class='fas fa-trash'></i>Borrar observacion</button>
									    </div>
								</div>";
					    }
					}?>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-12 text-left">
					<?php 
					$observe=true;
					if(count($datos_territorio['observaciones'])<1){
						echo "<div class='row'>
						    		<div class='col-md-12 text-center'>
						    			<h5>Sin Historial</h5>
						    		</div>
						    	</div>";
					}
					foreach ($datos_territorio['historial'] as $territorios ) {
						if($territorios['observacion']){
								echo "<div class='row'>
									    <div class='col-md-2 col-sm-4 col-lg-6 divobservaciones'>
									    	{$territorios['observacion']}
									    </div>
									    <div class='col-md-4 col-sm-6 col-lg-2 divobservaciones'>
									    	Creada:<span class='creacion'>".$ci->trabajar_fecha->darvuelta($territorios['creado'])."</span>
									    </div>
									    <div class='col-md-3 col-sm-2'>
									    	<button type='button' onclick='ReqDatosTerri.borrarObservacion({$id_terri},{$territorios['ID']})' class='btn btn-warning botonbaja botonesterri'><i class='fas fa-trash'></i>Borrar observacion</button>
									    </div>
								</div>";
					    }
					}?>
				</div>
			</div>-->
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
								<button type="button" class="btn btn-outline-primary showobser" onclick="ReqDatosTerri.crearobservacion(<?php echo $id_terri?>)">Crear observacion</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>