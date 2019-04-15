<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($datos_publicador);
?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	window.onload = ReqDatos.dataUserAdmin();
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
				<div class="col-md-6 col-sm-4 col-6 text-left divpersonaldata" id="div_email">
					<?php 
						if(empty($datos_publicador[0]['email']) || $datos_publicador[0]['email']==NULL){
							echo 'Sin datos del email';
						}else{
							echo ucwords($datos_publicador[0]['email']);
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
					<button type="button" class="btn btn-warning botonasignar"><i class="fas fa-user-plus"></i>Asignar territorio</button>
				</div>
				<div class="col-md-6 text-right">
					<button type="button" class="btn btn-warning botonbaja"><i class="fas fa-trash"></i>Dar de baja este publicador</button>
				</div>
				<div id="erroremail">
				</div>
			</div>
	</div>
</div>
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
					$territorios_normal=0;
					$territorios_campaña=0;
					$existen_territorios=false;
					foreach ($datos_publicador as $datos ) {
						if(!empty($datos['ID_publicador'])){
							$territorios_normal++;
						}
						if(!empty($datos['ID_publicador_campaing'])){
							$territorios_campaña++;
						}
						if(!empty($datos['ID_publicador']) || !empty($datos['ID_publicador_campaing'])){
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
							De servicio: <?php echo $territorios_normal; ?>
						</div>
						<div class="col-md-4 text-right">
							De campaña: <?php echo $territorios_campaña; ?>
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
									if(!empty($territorios['ID_publicador'])){
										echo '
										<div class="col-md-5">
											<div class="card" style="width: 18rem;">
											  <img src="..." class="card-img-top" alt="...">
											  <div class="card-body">
											    <h5 class="card-title">Card title</h5>
											    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
											  </div>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">Cras justo odio</li>
											    <li class="list-group-item">Dapibus ac facilisis in</li>
											    <li class="list-group-item">Vestibulum at eros</li>
											  </ul>
											  <div class="card-body">
											    <a href="#" class="card-link">Card link</a>
											    <a href="#" class="card-link">Another link</a>
											  </div>
											</div>
										</div>';
									}
									if(!empty($territorios['ID_publicador_campaing'])){
										echo '
										<div class="col-md-5">
											<div class="card" style="width: 18rem;">
											  <img src="..." class="card-img-top" alt="...">
											  <div class="card-body">
											    <h5 class="card-title">Card title</h5>
											    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
											  </div>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">Cras justo odio</li>
											    <li class="list-group-item">Dapibus ac facilisis in</li>
											    <li class="list-group-item">Vestibulum at eros</li>
											  </ul>
											  <div class="card-body">
											    <a href="#" class="card-link">Card link</a>
											    <a href="#" class="card-link">Another link</a>
											  </div>
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
