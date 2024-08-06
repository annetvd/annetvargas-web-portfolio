<?php
//errores de herramientas de desarrollador
session_start();
require "conexion.php";
require "funciones.php";
require "php/utils.php";
$user = "";
$password = "";

//session
if (isset($_SESSION['idUsuario'])) {
	if ($_SESSION['descripcion'] == 'Empaque') {
		header("location: Certificados\RepCertificados.php");
	} else {
		header("location: menu.php");
	}
}

//login
if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
	if (loginVacio($_POST['usuario'], $_POST['contraseña'])) {
		$errors = "Debe llenar todos los campos";
	} else {
		$errors = login($_POST['usuario'], $_POST['contraseña']);
	}
} else {
	$errors = "";
}

if (isset($_GET["user"])) {
	$user = $_GET["user"];
	$password = $_GET["password"];
}
?>
<!DOCTYPE html>
<html lang="es" class="h-100">

<head>
	<title>Iniciar sesión</title>
	<meta name charset="utf-8" />
	<meta name="autor" content="Annet Vargas Dueñas" />
	<meta name="viewport" content="width=device-width" />

	<link rel="shortcut icon" href="Imagenes\icono.ico">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
	<link rel="stylesheet" href="css/login.css">
</head>

<body class="h-100">
	<script>
		function validar() {
			var formulario = document.getElementById('formulario');
			valido = formulario.checkValidity();
		}
	</script>

	<hearder>
	</hearder>

	<main class="h-100">
		<div class="row m-0 p-0 no-gutters h-100">
			<img class="background" src="Imagenes/inicio.png" srcset="Imagenes/inicio.png 887w Imagenes/inicio-md.png" alt="" aria-hidden="true" />
			<span class="row py-5 px-4 justify-content-center no-gutters my-auto">
				<div class="col-12" style="max-width: 433px;">
					<FORM id="formulario" NAME="formulario" class="bg-content" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
						<div class="card border-0 bg-white rounded-3 mb-3 form-padding">
							<div>
								<!-- título -->
								<div class="text-center col-md-12 col-12 mt-5">
									<h4><strong>Iniciar sesión</strong></h4>
								</div>
							</div>
							<div class="row px-0 px-sm-5 py-3 overflow-hidden pb-0">
								<?php
								if ($errors == "") {
									echo '<p class="py-2"></p>';
								} else {
									echo '<p class="py-1"></p>';
								}
								?>
								<!-- registro -->
								<div class="col-12">
									<INPUT id="usuario" class="form-control col-12" type='text' maxlength='50' NAME="usuario" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Correo electrónico" value="<?php echo $user; ?>"></INPUT>
								</div>
								</p>
								<div class="col-12">
									<INPUT id="contraseña" class="form-control col-12 border-1" TYPE="password" maxlength='20' NAME="contraseña" required pattern="[a-z0-9A-Z\-\+_*#&\.]+" autocomplete="off" title="Solo se permiten letras mayusculas y minusculas, números y los siguientes caracteres: ._+-#&*" placeholder="Contraseña" value="<?php echo $password; ?>"></INPUT>
								</div>
								<?php
								if ($errors == "") {
									echo '<div class="col-12 my-2" style = "min-height: 15px;">';
								} else {
									echo '<div class="col-12 my-2" style = "font-size: .9rem; min-height: 23px;">';
								}
								?>
								<sapn id="mensaje" class="text-danger"><?php echo $errors; ?></sapn>
							</div>
						</div>
						<div class="text-muted px-0 px-sm-5 py-3 pt-0">
							<div class="row overflow-hidden gy-3">
								<div class="col-12">
									<INPUT id="inicioB" class="btn-sm btn col-12 rounded-1 text-white" style="background: #7eca28;" TYPE="submit" VALUE="Iniciar sesión" name="inicioB" onClick="validar();"></INPUT>
								</div>
								<div class="col-12">
									<hr class="mt-2 mb-2" />
								</div>
								<div class="col-12 text-center">
									<label class="form-label"><a href="Login/restaurarContrasena.php">¿Olvidaste tu contraseña?</a></label>
								</div>
							</div>
						</div>
				</div>
				<div class="bg-white text-center rounded-3 bg-content position-relative" style="padding-top: 10px; padding-bottom: 10px;">
					<img src="Imagenes\logoIn.png" class="img-fluid" style="max-height: 65px;">
				</div>
				</FORM>
			</span>
		</div>
	</main>

	<footer>
	</footer>

	<?php printModal(); ?>

	<!-- jquery -->
	<script src="Librerias/jquery.min.3.6.0.js"></script>
	<!-- bootstrap -->
	<script src="Librerias/bootstrap.min.js"></script>

</body>

</html>