<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($datos_publicador);
print_r($campaingdata);
$idpublicador = $datos_publicador[0]['id'];
$ci = &get_instance();
$ci->load->library("Trabajar_fecha");
?>
<script src="<?php echo CDN;?>/JS/usuarios.js"></script>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
</script>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata">
			<div class="row">
				<div class="col-md-8 col-sm-12 col-12  text-left">
					<h5>Datos personales</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-12 text-left">
					Nombre:
				</div>
				<div class="col-md-6 col-sm-4 col-6 text-left divpersonaldata" id="div_nombre">
					<?php echo ucwords($datos_publicador[0]['nombre']); ?>
				</div>
				<div class="col-md-2 col-sm-4 col-6 text-right">
					<i class="fas fa-pen-nib" id="boton_nombre" title="Actualizar datos" onclick="ReqDatos.update_publicador('<?php echo $datos_publicador[0]['nombre'];?>','nombre','<?php echo $datos_publicador[0]['id'];?>')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_nombre" style="display:none">Actualizar</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-12 text-left">
					Apellidos:
				</div>
				<div class="col-md-6 col-sm-4 col-6 text-left divpersonaldata" id="div_apellidos">
					<?php echo ucwords($datos_publicador[0]['apellidos']); ?>
				</div>
				<div class="col-md-2 col-sm-4 col-6 text-right">
					<i class="fas fa-pen-nib" id="boton_apellidos" title="Actualizar datos" onclick="ReqDatos.update_publicador('<?php echo $datos_publicador[0]['apellidos'];?>','apellidos','<?php echo $datos_publicador[0]['id'];?>')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_apellidos" style="display:none">Actualizar</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-12 text-left">
					Email:
				</div>
				<div class="col-md-6 col-sm-4 col-6 text-left divpersonaldata divemeaildata" id="div_email">
					<?php 
						if(empty($datos_publicador[0]['email']) || $datos_publicador[0]['email']==NULL){
							echo 'Sin datos del email';
						}else{
							echo $datos_publicador[0]['email'];
						}
					?>
				</div>
				<div class="col-md-2 col-sm-4 col-6 text-right">
					<i class="fas fa-pen-nib" id="boton_email" title="Actualizar datos" onclick="ReqDatos.update_publicador('<?php echo $datos_publicador[0]['email'];?>','email','<?php echo $datos_publicador[0]['id'];?>')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_email" style="display:none">Actualizar</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-12 text-left">
					Telefono:
				</div>
				<div class="col-md-6 col-sm-4 col-6 text-left divpersonaldata" id="div_telefono">
					<?php 
						if(empty($datos_publicador[0]['telefono']) || $datos_publicador[0]['telefono']==NULL){
							echo 'Sin datos del telefono';
						}else{
							echo ucwords($datos_publicador[0]['telefono']);
						}
					?>
				</div>
				<div class="col-md-2 col-sm-4 col-6 text-right">
					<i class="fas fa-pen-nib" id="boton_telefono" title="Actualizar datos publicador" onclick="ReqDatos.update_publicador('<?php echo $datos_publicador[0]['telefono'];?>','telefono','<?php echo $datos_publicador[0]['id'];?>')"></i><button type="button" class="btn btn-outline-primary butonupdate" id="actualizar_telefono" style="display:none">Actualizar</button>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 text-left">
					<button type="button" class="btn btn-warning botonasignar" onclick="ReqDatos.req_terri_asig()"><i class="fas fa-user-plus"></i>Asignar territorio</button>
					<?php 
			if(!empty($campaingdata) && $campaingdata['activa']){ ?>
					<button type="button" class="btn btn-warning botonasignar botocampaing" onclick="ReqDatos.req_terri_asig_campaing(<?php echo $campaingdata['ID'];?>)"><i class="fas fa-bullhorn"></i>Asignar territorio Campaña</button>
			<?php } ?>
				</div>
				<div class="col-md-6 text-right">
					<?php
						$datos_publicador[0]['asignado']==true ? $asignado=$datos_publicador[0]['asignado']:$asignado="no asignado";
						$datos_publicador[0]['asignado_campaing']==true ? $asignado_cam=$datos_publicador[0]['asignado_campaing']:$asignado_cam="no asignado campaing";
					?>
					<button type="button" class="btn btn-warning botonbaja" onclick="ReqDatos.borrarpublicador(<?php echo  $idpublicador;?>,'<?php echo $asignado;?>','<?php echo $asignado_cam;?>')"><i class="fas fa-trash"></i>Dar de baja este publicador</button>
				</div>
				<div id="erroremail">
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 text-left" id="divasignarterri">
					<div class="row">
						<div class="col-md-8">
							<div class="divasig">
								<div class="row text-right divfa">
									<div class="col-md-12 text-left" id="error">
										<span class="spanterriasig" id="spanerror">Introduce la fecha de entrega y devuelta</span>
										<span class="spanterriasig" id="spanerror2">La fecha de devuelta no puede ser menor que la de entrega</span>
								    </div>
									<div class="col-md-12">
										<i title='cerrar' class="fas fa-times" onclick='ReqDatos.closeasig("divasignarterri")'></i>
									</div>
								</div>
								<input type="text" class="form-control" placeholder="buscar territorio por observaciones" id="buscarterri" onkeyup="ReqDatos.filtrarterriasig()">
								<div id="terrifiltrados">
								</div>
								<br>
								<select id="showterriservicio" class="form-control">
								</select>
								<label class="labelfech" for="fechaentrega">Entrega territorio:</label>
								<input type="date" class="form-control" id="fechaentrega">
								<label class="labelfech" for="fechadevuelta">Devuelta territorio:</label>
								<input type="date" class="form-control" id="fechadevuelta"><br>
								<button class="btn btn-warning buttonasignar" onclick='ReqDatos.asignarterritorio("servicio","<?php echo $idpublicador;?>")'>Asignar</button>
								<button type="button" class="btn btn-warning verobservaciones" data-toggle="modal" data-target="#exampleModalCenter" onclick="ReqDatos.observaciones_asig()">Ver observaciones</button>
						    </div>
						</div>
					</div>
				</div>
				<!--TERRITORIOS PARA ASIGNAR-->
				<div class="col-md-6" id="showterricampaing">
					<div class="row">
						<div class="col-md-8">
							<div class="divasig">
								<div class="row text-right divfa">
									<div class="col-md-12 text-left">
										<span class="spanestadoterri">Asignar territorio de campaña</span>
									</div>
									<div class="col-md-12 text-left" id="error">
										<span class="spanterriasig" id="spanerrorcam">Introduce la fecha de entrega y devuelta</span>
										<span class="spanterriasig" id="spanerror2cam">La fecha de devuelta no puede ser menor que la de entrega</span>
								    </div>
									<div class="col-md-12">
										<i title='cerrar' class="fas fa-times" onclick='ReqDatos.closeasig("showterricampaing")'></i>
									</div>
								</div>
								<input type="text" class="form-control" placeholder="buscar territorio por observaciones" id="buscarterricamp" onkeyup="ReqDatos.filtrarterriasigcamp()">
								<div id="terrifiltradoscamp">
								</div>
								<br>
								<select id="showterriserviciocam" class="form-control">
								</select>
								<label class="labelfech" for="fechaentrega">Entrega territorio:</label>
								<input type="date" class="form-control" id="fechaentrega">
								<label class="labelfech" for="fechadevuelta">Devuelta territorio:</label>
								<input type="date" class="form-control" id="fechadevuelta"><br>
								<button class="btn btn-warning buttonasignar" onclick='ReqDatos.asignarterritorio_campaing(<?php echo $campaingdata['ID'] ?>,"<?php echo $idpublicador;?>")'>Asignar</button>
								<button type="button" class="btn btn-warning verobservaciones" data-toggle="modal" data-target="#exampleModalCenter" onclick="ReqDatos.observaciones_asig()">Ver observaciones</button>
						    </div>
						</div>
					</div>
				</div>
				<!--FIN DE TERRITORIOS PARA ASIGNAR-->
			</div>
	</div>
</div>
<!--- modal bootstrap para ver las observaciones del territorio-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Observaciones del territorio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='modal-observaciones'>
      </div>
    </div>
  </div>
</div>
<!-- fin del modal bootstrap-->
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata">
			<div class="row">
				<div class="col-md-8 col-sm-12 col-12  text-left">
					<h5>Datos de territorios</h5>
				</div>
			</div>
			<div class="row">
					<?php 
					$territorios_normal  =0;
					$territorios_campaña =0;
					$existen_territorios =false;
					foreach ($datos_publicador as $datos ) {
						if(!empty($datos['ID_publicador']) AND $datos['ID_publicador'] == $datos['id']){
							$territorios_normal++;
							$existen_territorios=true;
						}
						if(!empty($datos['ID_publicador_campaing'] AND $datos['ID_publicador_campaing'] == $datos['id'])){
							$territorios_campaña++;
							$existen_territorios=true;
						}
					}
					?>
				<div class="col-md-10 col-sm-4 col-12 text-left">
					<div class="row">
						<div class="col-md-4 text-left">
							Numero de Territorios<i class="fas fa-arrow-circle-right"></i>
						</div>
						<div class="col-md-4 text-right">
							De servicio: <span class="totalterri"><?php echo $territorios_normal; ?></span>
						</div>
						<div class="col-md-4 text-right">
							De campaña: <span  class="totalterri"><?php echo $territorios_campaña; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<?php 
							if($existen_territorios){
								echo '<div class="row">
									      <div class="col-md-8">
									      Territorios<i class="fas fa-arrow-circle-down"></i>
									      </div>
								      </div>
									 <div class="row lineashowterritorios">';

							foreach ($datos_publicador as $territorios) {
									if(!empty($territorios['ID_publicador']) AND $territorios['ID_publicador'] == $territorios['id']){
										echo '
										<div class="col-md-4">
											<div class="card" style="width:100%;">';
											if($territorios["imagen"]==null){
												echo ' <img src="'.CDN.'/images/sinimagen.jpg" class="card-img-top" alt="No existe imagen del territorio">';
											}else{
												echo '<img src="'.$territorios["imagen"].'" class="card-img-top" alt="No existe imagen del territorio">';
											}
											  echo '<div class="card-body">
											    <h5 class="card-title">Territorio de servicio</h5>';
											    ?>
											    <?php 
											    if($territorios['devuelta']<= "20".date('y-m-d')){
											    	echo '<span class="alerta">Territorio cumplido</span>';
											    }
											    echo '</div>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">
											    	Numero territorio:<span class="numeroterri">'.$territorios["numero_territorio"].'</span>
											    </li>
											    <li class="list-group-item">Zona:
											    	<span class="numeroterri">'.$territorios["zona"].'</span>
											    </li>
											    <li class="list-group-item">
											     	<div>
											     		Entrega:<span class="numeroterri">'.$ci->trabajar_fecha->darvuelta($territorios['entrega']).'</span>
											     	</div>
											     	<div>
											     		Devuelta:<span class="numeroterri">'.$ci->trabajar_fecha->darvuelta($territorios['devuelta']).'</span>
											     	</div>
											    </li>';?>
											    <li class="list-group-item"><button class="btn btn-secondary" type="button" onclick="ReqDatos.devolver_territorio(<?php echo $territorios['numero_territorio'];?>,<?php echo $territorios['idterritorios'];?>,<?php echo $territorios['id'];?>,'<?php echo $territorios["zona"];?>');">Devolver territorio</button></li>
											  <?php echo '</ul>
											</div>
										</div>';
									}
								}
								foreach ($datos_publicador as $territorioscampa) {
									if(!empty($territorioscampa['ID_publicador_campaing']) AND $territorioscampa['ID_publicador_campaing'] == $territorioscampa['id']){
										$tipo = 'campaña';
										echo '
										<div class="col-md-4">
											<div class="card divcampa" style="width: 100%;">
											  <img src="'.$territorioscampa["imagen"].'" class="card-img-top" alt="No existe imagen del territorio">
											  <div class="card-body">
											    <h5 class="card-title"><i class="fas fa-bullhorn bocina"></i> Territorio de campaña </h5>'?>
											    
											    <?php 
											    if($territorioscampa['devuelta_campaing']<= "20".date('y-m-d')){
											    	echo '<span class="alerta">Territorio cumplido</span>';
											    }
											    echo '</div>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">
											       Numero territorio:<span class="numeroterri">'.$territorioscampa["numero_territorio"].'</span>
											    </li>
											    <li class="list-group-item">
											        Zona:<span class="numeroterri">'.$territorioscampa["zona"].'</span>
											    </li>
											    <li class="list-group-item">
											     	<div>
											     		Entrega:<span class="numeroterri">'.$ci->trabajar_fecha->darvuelta($territorioscampa['entrega_campaing']).'</span>
											     	</div>
											     	<div>
											     		Devuelta:<span class="numeroterri">'.$ci->trabajar_fecha->darvuelta($territorioscampa['devuelta_campaing']).'</span>
											     	</div>
											     </li>
											    <li class="list-group-item"><button class="btn btn-secondary" type="button" onclick="ReqDatos.devolver_territorio_campaing('.$territorioscampa['numero_territorio'].','.$territorios['idterritorios'].','.$territorios['id'].')">Devolver territorio</button></li>
											  </ul>
											</div>
										</div>';
									}
								}
								echo '</div>';
							}?>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
