<?php
defined('BASEPATH') OR exit('No direct script access allowed');
print_r($datos);
$check_asig=false;
foreach ($datos['control'] as $checkterri){
	if(!empty($checkterri['nombre'])){
		$check_asig=true;
	}
}
?>
<script src="<?php echo CDN;?>/JS/campaing.js"></script>
<script>
	let Campaing = new campaing('<?php echo URL; ?>');
</script>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata">
		<?php 
			if($datos['datos']['fecha_cierre']<=date("Y-m-d")){
				echo '<div class="row">
						<div class="col-md-12 text-left">
							<h5 style="color:#dc3545;"><i class="far fa-bell ale"></i> La fecha de la campaña ha vencido</h5>
						</div>
					</div>';
			}
		?>
		<div class="row">
			<div class="col-md-4 text-left">
				Nombre de la campaña:  <span class='spanestadoterri'><?php echo $datos['datos']['nombre_campaing'];?></span>
			</div>
			<div class="col-md-4 text-left">
				<?php $datos['datos']['activa'] ? $estado='<span class="spanactivo">Activa</span><i class="fas fa-check"></i>' : $estado='<span class="spancerrado">Cerrada</span><i class="fas fa-times spancerrado"></i>';?>
				Estado : <?php echo $estado;?>
			</div>
			<div class="col-md-4 text-right">
				<button type="button" class="btn btn-dark botondesactivarcampaing" onclick="Campaing.desactivarcampaing(<?php echo $datos['datos']['ID'];?>,<?php echo $check_asig;?>)"><i class="fas fa-arrow-alt-circle-down"></i>  Desactivar campaña</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 text-left">
				Fecha de apertura: <span class='spanestadoterri'><?php echo $datos['datos']['fecha_apertura'];?></span>
			</div>
			<div class="col-md-4 text-left">
				<?php 
					if($datos['datos']['fecha_cierre']<=date("Y-m-d")){?>
						Fecha de cierre: <span class='spanestadoterri' style="color:#dc3545;"><?php echo $datos['datos']['fecha_cierre'];?></span>
				<?php } else{ ?>
						Fecha de cierre: <span class='spanestadoterri'><?php echo $datos['datos']['fecha_cierre'];?></span>
				<?php } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 text-left">
				Territorios para predicar: <span class='spanestadoterri'><?php echo $datos['datos']['numero_territorios'];?></span>
			</div>
			<div class="col-md-4 text-left">
				Territorios predicados: <span class='spanestadoterri'><?php echo $datos['datos']['territorios_predicados'];?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-left">
				<button type="button" id="grafico" class="btn btn-warning botonescampaing">Ver gráfico</button>
				<button type="button" id="estadoterritorios" class="btn btn-primary botonescampaing" onclick="Campaing.show_terri()">Ver estado de territorios</button>
				<button type="button" class="btn btn-danger botonescampaing" onclick="Campaing.borrarcampaing(<?php echo $datos['datos']['ID'];?>,<?php echo $check_asig;?>)"><i class="fas fa-trash"></i> Borrar Campaña</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-1">
	</div>
	<div class="col-md-10 infoboxdata showterri" id="showterri">
		<div class='row'>
			<div class="col-md-6 text-left">
				<h5 class="titlecontrol">Control de territorios</h5>
			</div>
			<div class="col-md-6 text-right">
				<i class="fas fa-times-circle circlecerrar" onclick="Campaing.remove_grafico('showterri');"></i>
			</div>
		</div>
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
		<?php 
			foreach ($datos['control'] as $control) {
					$control['predicado'] ? $predicado = '<span class="spanactivo">Predicado</span><i class="fas fa-check"></i>' : $predicado ='<span class="spancerrado">Sin predicar</span><i class="fas fa-times spancerrado"></i>';
					if(!empty($control['nombre'])){
						$asignado  = $control['nombre']." ".$control['apellidos'];
						$predicado = '<span class="proceso">Trabajandose</span><i class="fas fa-walking trabajandose"></i>';
					}else{
						$asignado = "Sin asignar";
					}
				echo "
				<div class='first'>
					<div class='row divstateterri'>
						<div class='col-md-3 text-left'>
							<span class='spanestadoterri'>{$control['numero_territorio']}</span>
						</div>
						<div class='col-md-3 text-left'>
						  	<span class='spanestadoterri'>{$control['zona']}</span>
						</div>
						<div class='col-md-3 text-left'>
						   <span class='spanestadoterri'>{$asignado}</span>
						</div>
						<div class='col-md-3 text-left'>
						  	<span class='spanestadoterri'>{$predicado}</span>
						</div>
					</div>
				</div>";
			}
		?>
	</div>
</div>