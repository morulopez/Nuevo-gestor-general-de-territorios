<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>')
	window.onload = ReqDatos.dataUserAdmin('<?php echo $id;?>');
</script>
	<div class="col-md-10">
		<div class="row">
			<div class="col-md-6">
				<h3 class="h3perfil">Mi perfil</h3>
				<div id="listdata">
				</div>
			</div>
		</div>
	</div>