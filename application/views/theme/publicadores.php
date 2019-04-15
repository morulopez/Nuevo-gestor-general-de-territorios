<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mas=$this->uri->segment(2)+1;
$menos=$this->uri->segment(2)-1;
if($this->uri->segment(2)<1){
	redirect(site_url('publicadores/1'));
}
?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id;?>','<?php echo $this->uri->segment(2); ?>');
	ReqDatos.req_publicadores();
</script>

<div class="col-md-3">
	<nav class="navbar navbar-light">
		<div class="divagregar divagregartop"><i class="fas fa-user-tie"></i><a href="#modal_add_publicadores"><span class="divagregartopancor">Agregar publicador</span></a></div>
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
				<!--En este div (<div id="listdatapubli">) mostramos a tods los publicadores de su respectiva congregacion lo hacemos a traves de la funcion de javascript (ReqDatos.req_publicadores();) cargada arriba-->
				<div id="listdatapubli">
				</div>
				<div>
					<nav aria-label="Page navigation example">
					  <ul class="pagination">
					  	<li class="page-item">
					      <a class="page-link" href="<?php echo site_url('publicadores/'.$menos);?>" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li id="paginationpubli">
						</li>
						<li class="page-item">
					      <a class="page-link" href="<?php echo site_url('publicadores/'.$mas) ?>" aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<div id="modal_info_publicadores" class="modal_info_publicadores">
		<div class="content_modal_publicadores">
			<div class="row">
				<div class="col-md-12 text-right cerrarmodal">
					<a href="#" class="close-modal" id="cerrar-modal" onclick="ReqDatos.load_again_publicadores()">X</a>
				</div>
			</div>
				<!--En esta ventana modal se muestra los datos de un publicador en concreto,llamamos a una vista por Ajax y se carga en la ventana modal,al pulsar el boton que esta escrito en la funcion de javascript (ReqDatos.req_publicadores();)-->
			<div class="row">
					<div class="col-md-12" id="show_info_publicador">
					</div>
			</div>
		</div>
	</div>