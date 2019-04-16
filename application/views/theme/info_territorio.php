<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($datos_publicador);
?>
<script>
	let ReqDatosTerri = new territorios('<?php echo URL; ?>','<?php echo $id;?>','<?php echo $this->uri->segment(2); ?>');
</script>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata">
		<h1>ifo territorio</h1>
	</div>
</div>