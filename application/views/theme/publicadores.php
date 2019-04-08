<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	window.onload = ReqDatos.req_publicadores();
</script>

<div class="col-md-3">
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
		<div class="divagregar"><i class="fas fa-user-tie"></i><a href="#modal_add_publicadores"><span>Agregar publicador</span></a></div>
	</nav>
</div>
<div id="modal_add_publicadores" class="modal_add_publicadores">
	<div class="content_modal">
		<div class="row">
			<div class="col-md-12 text-right cerrarmodal">
				<a href="#" class="close-modal" id="cerrar-modal">X</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-left">
				<form id="formpublicador">
					<div class="form-group">
					    <label for="nombrepublicador">Nombre:</label>
					    <input type="text" class="form-control" id="nombrepublicador" aria-describedby="emailHelp" placeholder="Nombre">
					</div>
					<div class="form-group">
					    <label for="apellidospublicador">Apellidos:</label>
					    <input type="text" class="form-control" id="apellidospublicador" aria-describedby="emailHelp" placeholder="Apellidos">
					</div>
					<div class="form-group">
					    <label for="telefono">Telefono:</label>
					    <input type="number" class="form-control" id="telefono" aria-describedby="emailHelp" placeholder="Telefono">
					</div>
					<div class="form-group">
					    <label for="email">Email:</label>
					    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
					  <button type="button" onclick="ReqDatos.agregar_Publicador();" class="btn btn-primary">Crear publicador</button><span id="error"></span>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="col-md-10">
    <div class="row">
		<div class="col-md-9">
			<h3 class="h3perfil">Publicadores de la congregación <?php echo ucwords($this->session->userdata['nombre_congregacion']);?> </h3>
			<div id="listdatapubli">
			</div>
		</div>
	</div>
</div>
<div id="modal_info_publicadores" class="modal_info_publicadores">
	<div class="content_modal_publicadores">
		<div class="row">
			<div class="col-md-12 text-right cerrarmodal">
				<a href="#" class="close-modal" id="cerrar-modal">X</a>
			</div>
			<div class="row">
				<div class="col-md-12" id="show_info_publicador">
				</div>
			</div>
		</div>
	</div>
</div>