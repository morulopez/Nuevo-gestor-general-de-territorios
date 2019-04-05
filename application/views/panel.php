<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Gestion de territorios</title>
	<!--MIS ESTILOS-->
	<link rel="stylesheet" href="<?php echo CDN;?>/CSS/estilos.css">
	<script src="<?php echo CDN;?>/JS/login.js"></script>

	<!--LIBRERIA FONTAWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="font-awesome-animation.min.css">

	<!--BOOTSTRAP ESTILOS-->
	<script src="<?php echo CDN;?>/bootstrap/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="<?php echo CDN;?>/bootstrap/js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="<?php echo CDN;?>/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo CDN;?>/bootstrap/css/bootstrap.min.css">

	<!--Libreria CHART.JS-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
	<!--Libreria sweetalert2-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

</head>
<body>
	<div class="container-fluid">	
		<div class="row">
			<div class="col-md-2 col-12 col-sm-2 sidebar align-middle">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-lg-12 divcongre text-center">
						<span class="spancongre"> Congregación <?php echo ucwords($congregacion); ?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-12 col-lg-12">
						<ul class="sidebarli">
							<a href="<?php echo site_url('mi_perfil')?>"><li><i class="far fa-smile"></i>         <span>Mi perfil   </span></li></a>
							<a href="<?php echo site_url('publicadores')?>"><li><i class="fas fa-address-card"></i>  <span>Publicadores</span></li></a>
							<a href="<?php echo site_url('territorios')?>"><li><i class="fas fa-globe">       </i>  <span>Territorios </span></li></a>
							<a href="<?php echo site_url('campañas')?>"><li><i class="fas fa-bullhorn">    </i>  <span>Campañas    </span></li></a>
							<li><i class="far fa-bell ale">    </i>  <span>Alertas     </span></li>
							<li><i class="fas fa-play">    </i>  <span>Videos tutoriales     </span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-10 col-12 col-sm-10">
				<div class="row text-right divnav">
					<div class="col-md-8 col-12 text-left">
						<nav class="navbar  navegador text-left">
			  				<form class="form-inline">
							    <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
							    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
							</form>
						</nav>
					</div>
					<div class="col-md-2 infousuario text-left">
						<div class="usermenu">
							<i class="far fa-address-book"></i><span> Bienvenido: <strong class="nombreuser"><?php echo ucwords($nombre_usuario); ?></strong></span>
						</div>
					</div>
					<div class="col-md-2">
						<span class="soporte crerrarsesion">Cerrar sesion |</span>
						<span class="soporte" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Soporte tecnico</span>
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Nuevo mensaje</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <form>
						          <div class="form-group">
						            <label for="recipient-name" class="col-form-label">Asunto</label>
						            <input type="text" class="form-control" id="recipient-name">
						          </div>
						          <div class="form-group">
						            <label for="message-text" class="col-form-label">Mensaje</label>
						            <textarea class="form-control" id="message-text"></textarea>
						          </div>
						        </form>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						        <button type="button" class="btn btn-primary">Enviar mensaje</button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
				<div class="row conteprincipal">
					<?php echo $contenido; ?>
					<!--<canvas id="myChart"></canvas>
	<script>
		data = {
    datasets: [{
        data: [40, 60],
        backgroundColor: [
                'rgba(38, 194, 129, 1)',
                'rgba(231, 76, 60, 1)',
        ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Echo',
        'Por hacer'
    ]
};		var ctx = document.getElementById('myChart').getContext('2d');
		var myDoughnutChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: data,
		    options:{}
		});
	</script>-->
				</div>
			</div>
		</div>
	</div>
</body>
</html>