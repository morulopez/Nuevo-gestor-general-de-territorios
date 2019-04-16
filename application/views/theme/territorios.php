<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$mas=$this->uri->segment(2)+1;
$menos=$this->uri->segment(2)-1;
if($this->uri->segment(2)<1){
	redirect(site_url('territorios/1'));
}
?>
<script>
	let ReqDatosTerri = new territorios('<?php echo URL; ?>','<?php echo $id;?>','<?php echo $this->uri->segment(2); ?>');
	ReqDatosTerri.req_territorios();
</script>

<div class="col-md-3">
	<nav class="navbar navbar-light">
		<div class="divagregar divagregartop"><i class="fas fa-window-maximize"></i><a href="#modal_add_territorios"><span class="divagregartopancor">Agregar Territorio</span></a></div>
	</nav>
</div>
<div id="modal_add_territorios" class="modal_add_territorios">
	<div class="content_modal">
		<div class="row">
			<div class="col-md-12 text-right cerrarmodal">
				<a href="#" class="close-modal" id="cerrar-modal">X</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-left">
				<form id="formpterritorios">
					<div class="form-group">
					    <label for="numero">Numero de territorio:</label>
					    <input type="number" class="form-control" id="numero" aria-describedby="emailHelp" placeholder="Numero de territorio">
					</div>
					<div class="form-group">
					    <label for="zona">Zona del territorio:</label>
					    <input type="text" class="form-control" id="zona" aria-describedby="emailHelp" placeholder="Zona del territorio">
					</div>
					<div class="form-group">
					    <label for="img">Imagen:</label><br>
					    <input type="file" class="inputfile" id="contefile" aria-describedby="emailHelp">
					    <button type="button" class="botonimag" onclick="ReqDatosTerri.activarFile();"><i class="fas fa-images"></i>Agregar Imagen</button><span id="nombreimg"></span>
					    <script>
					    	document.getElementById('contefile').addEventListener('change',()=>{
					    		document.getElementById('nombreimg').innerHTML= document.getElementById('contefile').files[0].name;
					    	})
					    </script>
					</div>
					  <div class="row">
					  	<div class="col-md-6 text-left">
					  		<button type="button" onclick="ReqDatosTerri.add_Territorio();" class="btn btn-primary">Crear territorio</button><span id="divcargaterritorios"></span>
					    </div>
					    <div class="col-md-6 text-right">
					  		<span id="errorterritorios"></span>
					    </div>
					  </div>
				</form>
			</div>
		</div>
	</div>
</div>
	<div class="col-md-10">
	    <div class="row">
			<div class="col-md-9">
				<h3 class="h3perfil">Territorios de la congregación <?php echo ucwords($this->session->userdata['nombre_congregacion']);?> </h3>
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
	<div id="modal_info_territorios" class="modal_info_territorios">
		<div class="content_modal_territorios">
			<div class="row">
				<div class="col-md-12 text-right cerrarmodal">
					<a href="#" class="close-modal" id="cerrar-modal">X</a>
				</div>
				<!--onclick="ReqDatosTerri.load_again_territorios()"-->
			</div>
				<!--En esta ventana modal se muestra los datos de un territorio en concreto,llamamos a una vista por Ajax y se carga en la ventana modal,al pulsar el boton que esta escrito en la funcion de javascript (ReqDatosTerri.req_territorios();)-->
			<div class="row">
					<div class="col-md-12" id="show_info_territorios">
					</div>
			</div>
		</div>
	</div>