<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	window.onload = ReqDatos.dataUserAdmin();
</script>

<div class="col-md-4">
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
		<i class="fas fa-user-tie"></i> <a href="#modal_add_publicadores"><span>Agregar publicador</span></a>
	</nav>
</div>
<div id="modal_add_publicadores" class="modal_add_publicadores">
	<div class="content_modal">
		<div class="row">
			<div class="col-md-12 text-right cerrarmodal">
				<a href="#" class="close-modal">X</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-left">
				<form>
					<div class="form-group">
					    <label for="exampleInputEmail1">Nombre</label>
					    <input type="text" class="form-control" id="nombrepublicador" aria-describedby="emailHelp" placeholder="Nombre">
					</div>
					<div class="form-group">
					    <label for="exampleInputEmail1">Apellidos</label>
					    <input type="text" class="form-control" id="apellidospublicador" aria-describedby="emailHelp" placeholder="Apellidos">
					</div>
					<div class="form-group">
					    <label for="exampleInputEmail1">Telefono</label>
					    <input type="text" class="form-control" id="telefono" aria-describedby="emailHelp" placeholder="Telefono">
					</div>
					<div class="form-group">
					    <label for="exampleInputEmail1">Email</label>
					    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					</div>
					  <button type="button" class="btn btn-primary">Crear publicador</button>
				</form>
			</div>
		</div>
	</div>
</div>