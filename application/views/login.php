<!DOCTYPE html>
<html>
<head>
	<title>Gestion de territorios Login</title>
	<!--MIS ESTILOS-->
	<link rel="stylesheet" href="<?php echo CDN;?>/CSS/estilos_login.css">
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
		let Logueo = new login("<?php echo URL ?>");
	</script>
	<div class="container-fluid principal">
		<div class="row">
						<div class="col-md-4">
						</div>
						<div class="col-md-4 text-center divnube">
							<i class="fas fa-cloud"></i>
							<h4>GESTOR DE TERRITORIOS (LOGIN)</h4>
						</div>
		</div>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4 divlogin">
				<form>
					 <div class="form-group">
					    <label for="exampleInputEmail1">Usuario</label>
					    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Usuario">
					</div>
					<div class="form-group">
					    <label for="exampleInputPassword1">Contraseña</label>
					    <input type="Password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
					</div>
					<div class="row">
					  	<div class="col-md-3">
					  		<button type="submit" class="btn btn-primary">Acceder</button>
					    </div>
					    <div class="col-md-9 text-right">
					  		<div class="divcuenta"><span class="crearcuenta" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"><i class="fas fa-user"></i>  Crear una cuenta</span>
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Inserta la contraseña de invitación</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <div class="modal-body">
								        <form>
								          <div class="form-group">
								            <label for="recipient-name"  class="col-form-label">Contraseña:</label>
								            <input type="text" class="form-control" id="recipient-name" name="clave">
								          </div>
								      </div>
								      <div class="modal-footer">
								      	<!-- con esta funcion de javascript accedemos a nuestra carpeta personal de JS y mediante fetch confirmaremos la clave secreta-->
								      	 <div class="row">
								        	<div class="col-md-12" id="divcarga">
								        	</div>
								        </div>
								        <button type="button" class="btn btn-primary" onclick="Logueo.secret_key()">Enviar</button>
								        </form>
								      </div>
								    </div>
								  </div>
								</div>
					  		</div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>






