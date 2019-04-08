<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	window.onload = ReqDatos.dataUserAdmin();
</script>
<h1>HOLLLLAAAAAAAAAAA</h1>