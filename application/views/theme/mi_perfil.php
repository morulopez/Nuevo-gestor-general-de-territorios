<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo CDN;?>/JS/usuarios.js"></script>
<script src="<?php echo CDN;?>/JS/Chart.js"></script>
<script>
	let ReqDatos = new dataUser('<?php echo URL; ?>','<?php echo $id; ?>');
	ReqDatos.dataUserAdmin();
</script>
	<div class="col-md-12" style="margin-top: 10px;">
		<div class="row">
			<div class="col-md-7">
				<div id="listdata">
				</div>
				<div class="row">
					<div id="erroremail">
					</div>
				</div>
			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-3 text-center">
				<div class="divselectyear">
					<select id="yearselect" class="form-control selectyear">
					</select>
				</div>
			</div>
		</div>
		<br>
		<hr>
		<div class="row">
			<div class="col-md-7">
				<div id="listdata" class="datosservice">
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-7 fir" style="margin-bottom: 80px!important;">
				<div class='first'>
					<div class='row titlerowfirst'>
						<div class='col-md-3 text-left'>
							<span class='spanestadotitle'>Numero:</span>
						</div>
						<div class='col-md-3 text-left'>
							<span class='spanestadotitle'>Zona:</span>
						</div>
						<div class='col-md-3 text-left'>
							<span class='spanestadotitle'>Asignado:</span>
						</div>
						<div class='col-md-3 text-left'>
							<span class='spanestadotitle'>Estado:</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div id="listdata" style="background-color: #fff;padding-top: 40px;">
					<div id="porcentajes">
					</div>
					<div style="padding-bottom: 80px!important;">
						<canvas id="myChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>