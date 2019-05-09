<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo CDN;?>/JS/campaing.js"></script>
<script>
	const Campaing = new campaing('<?php echo URL; ?>');
	Campaing.req_campaing();
</script>
<div class="col-md-3">
	<nav class="navbar navbar-light">
		<div class="divagregar divagregartop"><i class="far fa-bell ale"></i><a href="#modal_add_campaing"><span class="divagregartopancor" id="crearcampaingfirst">Crear nueva campaña</span></a></div>
	</nav>
</div>
<div id="modal_add_campaing" class="modal_add_campaing">
	<div class="content_modal_campaing">
		<div class="row">
			<div class="col-md-12 text-right cerrarmodal">
				<a href="#" class="close-modal" id="cerrar-modal">X</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-left">
				<form id="formcampaing">
					<div class="form-group">
					    <label for="nombrepublicador">Nombre campaña:</label>
					    <input type="text" class="form-control" id="nombrepublicador" aria-describedby="emailHelp" placeholder="Nombre">
					</div>
					<div class="form-group">
					   <label class="labelfech" for="fechaentrega">Inicio campaña:</label>
						<input type="date" class="form-control" id="fechaentrega">
					</div>
					<div class="form-group">
					    <label class="labelfech" for="fechadevuelta">Fecha de cierre:</label>
						<input type="date" class="form-control" id="fechadevuelta"><br>
					</div>
					<div class="form-group">
					    <label for="email">Observaciones de campaña:</label>
					    <textarea id="infoobservacion" placeholder="Escribe las observaciones sobre la campaña..."></textarea><br>
					</div>
					  <button type="button" id="crearcampaing" class="btn btn-primary">Crear campaña</button><span id="error"></span>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="col-md-10">
	<div class="row">
		<div class="col-md-9">
			<h3 class="h3perfil">Campañas de la congregación <?php echo ucwords($this->session->userdata['nombre_congregacion']);?></h3>
				<!--En este div (<div id="listdatapubli">) mostramos a tods los publicadores de su respectiva congregacion lo hacemos a traves de la funcion de javascript (ReqDatos.req_publicadores();) cargada arriba-->
			<div id="listdatapubli">
			</div>
		</div>
	</div>
</div>
<div id="modal_info_campaing" class="modal_info_campaing">
		<div class="content_modal_campaing">
			<div class="row">
				<div class="col-md-12 text-right cerrarmodal">
					<a href="#" class="close-modal" id="cerrar-modal">X</a>
				</div>
				<!--onclick="Campaing.load_again_territorios()"-->
			</div>
				<!--En esta ventana modal se muestra los datos de una camapaña en concreto,llamamos a una vista por Ajax y se carga en la ventana modal,al pulsar el boton que esta escrito en la funcion de javascript (ReqDatosTerri.req_territorios();)-->
			<div class="row">
					<div class="col-md-12" id="show_info_campaing">
					</div>
			</div>
					<script src="<?php echo CDN;?>/JS/Chart.js"></script>
			<div class="row">
                <div class="col-md-1">
                </div>
				<div class="col-md-10 infoboxdata divchair" id="chair">
					<div class="row">
						<div class="col-md-8 text-left">
							<h5>Gráfico del trabajo realizado</h5>
						</div>
						<div class="col-md-4 text-right">
							<i class="fas fa-times-circle circlecerrar" onclick="Campaing.remove_grafico('chair');"></i>
						</div>
					</div>
					<div id="porcentajes">
					</div>
					<canvas id="myChart"></canvas>
				</div>
		</div>
	</div>
</div>