<!DOCTYPE html>
<html>
<head>
	<title>Registro</title>
	<!--MIS ESTILOS-->
	<link rel="stylesheet" href="<?php echo CDN;?>/CSS/estilos_registro.css">
	<!-- MIS ARCHIVOS JS-->
	<script src="<?php echo CDN;?>/JS/login.js"></script>
	<!--ESTILOS BOOTSTRAP-->
	<link rel="stylesheet" href="<?php echo CDN;?>/bootstrap/css/bootstrap.min.css">
	<script src="<?php echo CDN;?>/bootstrap/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="<?php echo CDN;?>/bootstrap/js/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="<?php echo CDN;?>/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!--LIBRERIA FONTAWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!--sweetalert2-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</head>
<body>
	<script>
		let Registro = new login('<?php echo URL; ?>')
	</script>
	<div class="container-fluid principal">
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4 text-center iconoregistro">
				<i class="fas fa-edit"></i>
				<h5>Pagina de registro</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4 divformulario">
				<form class="needs-validation" novalidate>
				   <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom01">Nombre de Congregacion</label>
				      <input type="text" class="form-control" id="validationCustom01" placeholder="Nombre de congregacion" required>
				    </div>
				  </div>
				  <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom02">Provincia</label>
				      <input type="text" class="form-control" id="validationCustom02" placeholder="provincia" required>
				    </div>
				  </div>
				  <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom03">Localidad</label>
				      <input type="text" class="form-control" id="validationCustom03" placeholder="Localidad" required>
				    </div>
				  </div>
				  <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom04">Nombre del administrador</label>
				      <input type="text" class="form-control" id="validationCustom04" placeholder="Nombre del administrador" required>
				    </div>
				   </div>
				   <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom05">Apellidos</label>
				      <input type="text" class="form-control" id="validationCustom05" placeholder="Apellidos" required>
				    </div>
				   </div>
				   <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustomUsername">Nombre de usuario</label>
				      <div class="input-group">
				        <input type="text" class="form-control" id="validationCustomUsername" placeholder="Nombre de usuario" aria-describedby="inputGroupPrepend" required>
				      </div>
				    </div>
					</div>
				  <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom06">Email</label>
				      <input type="email" class="form-control" id="validationCustom06" placeholder="Email" required>
				    </div>
				   </div>
				   <div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom07">Contraseña</label>
				      <input type="password" class="form-control" id="validationCustom07" placeholder="Contraseña" required>
				    </div>
					</div>
					<div class="form-row">
				    <div class="col-md-12">
				      <label for="validationCustom08">Valida la contraseña</label>
				      <input type="password" class="form-control" id="validationCustom08" onkeyup="Registro.controlPass()" placeholder="Valida la contraseña" required>
				      <div class="row">
				      	<div class="col-md-12">
				      		<span class="passinvalid">La contraseña no coincide</span>
				      		<span class="passvalid">La contraseña coincide</span>
				      	</div>
				      </div>
				    </div>
				  </div>
				  <br>
				  <div class="row">
					  <div class="col-md-6">
					  	<!--<button class="botonregistro" type="submit" onclick="Registro.Validar()">Guardar y registrarse</button>-->
					  	<div id="divcarga">
					  	</div>
					  </div>
					  <div class="col-md-6 text-right">
					  	<a href="<?php echo site_url('Inicio_territorios/Login')?>" class="enlace"><span>Volver al login</span></a>
					  </div>
				  </div>
				</form>
				<button onclick="Registro.register_User()">alternativo</button>
			</div>
		</div>
</div>
</body>
</html>