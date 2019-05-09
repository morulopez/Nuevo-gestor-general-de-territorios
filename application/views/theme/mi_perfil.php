<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo CDN;?>/JS/usuarios.js"></script>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	window.onload = ReqDatos.dataUserAdmin();
</script>
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-9">
				<h3 class="h3perfil">Mi perfil</h3>
				<div id="listdata">
				</div>
				<div class="row">
					<div id="erroremail">
					</div>
				</div>
			</div>
		</div>
	</div>