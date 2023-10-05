<?php
    session_start();
    
    ///////////////////// Reviso si ya está iniciada la sesión
    
    if (isset($_SESSION['idUsuario'])) {
		if ($_SESSION['descripcion'] == 'Empaque'){
			header("location: Certificados\RepCertificados.php");
		} else{
			header("location: menu.php");
	    }
	}
	
    require "conexion.php";
    require "funciones.php";

    if (!empty($_POST)) {
        if (loginVacio($_POST['usuario'], $_POST['contraseña'])) {
            $errors = "Debe llenar todos los campos";
        }
        else{
            $errors = login($_POST['usuario'], $_POST['contraseña']);
        }
    } else{
        $errors = "";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar sesión</title>
    <meta name charset="utf-8"/>
    <meta name = "autor" content = ""/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
    
    <link rel="shortcut icon" href="..\Imagenes\icono.ico">

    <style type="text/css">
        a { color: #19221f; text-decoration: none;}
        a:hover { color: #7eca28; }
    </style>
</head>
<body>
	<script>
	    function validar(){
			var formulario = document.getElementById('formulario');
			valido = formulario.checkValidity();
		}
		
		$(window).on('popstate', function(event) {
            return false;
        });
	</script>

    <!--Cabecera-->
	<hearder>
    </hearder>

    <main>
        <div class = "container-fluid m-0 p-0">
            <div class="card col-12 border-0">
	        	<iframe style="min-height: 625px; height: 100vh;" src= "Imagenes\inicio.html" id = "fondo"></iframe>
				<div class="card-img-overlay m-0 p-0 row align-items-center" style="overflow: hidden;">
				    <div class="row py-5 justify-content-center">
		                <div class = "col-sm-12 col-md-12" style="max-width: 460px;">
		                    <FORM id = "formulario" NAME="formulario" method = 'POST' action = '<?php $_SERVER['PHP_SELF']?>'>
		                        <div class="card border-0 bg-white px-4 rounded-3 mb-3">
		                            <div>
		                                <!-- título -->
		                                <div class="text-center col-md-12 col-12 mt-5">
		                                    <h4><strong>Iniciar sesión</strong></h4>
		                                </div>
		                            </div>
		                            <div class="row px-5 py-3 overflow-hidden pb-0">
		                                <?php
		                                    if ($errors == ""){
		                                        echo '<p class="py-2"></p>';
		                                    } else{
		                                        echo '<p class="py-1"></p>';
		                                    }
		                                ?>
		                                <!-- registro -->
		                                <div class="col-12">
		                                    <INPUT id = "usuario" class = "form-control col-12" type = 'text' maxlength='50' NAME="usuario" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Correo electrónico"></INPUT>
		                                </div>
		                                </p>
		                                <div class="col-12">
		                                    <INPUT id = "contraseña" class = "form-control col-12 border-1" TYPE="password" maxlength='20' NAME="contraseña" required pattern="[a-z0-9A-Z\-\+_*#&\.]+" autocomplete="off" title = "Solo se permiten letras mayusculas y minusculas, números y los siguientes caracteres: ._+-#&*" placeholder="Contraseña"></INPUT>
		                                </div>
		                                <?php
		                                    if ($errors == ""){
		                                        echo '<div class="col-12 my-2" style = "min-height: 15px;">';
		                                    } else{
		                                        echo '<div class="col-12 my-2" style = "font-size: .9rem; min-height: 23px;">';
		                                    }
		                                ?>
		                                    <sapn id = "mensaje" class = "text-danger"><?php echo $errors; ?></sapn>
		                                </div>
		                            </div>
		                            <div class="text-muted px-5 py-3 pt-0">
		                                <!-- botones -->
		                                <div class="row overflow-hidden gy-3">
		                                    <!-- botones -->
		                                    <div class="col-12">
		                                        <INPUT id = "inicioB" class = "btn-sm btn col-12 rounded-1 text-white" style = "background: #7eca28;" TYPE="submit" VALUE="Iniciar sesión" name = "inicioB" onClick="validar();"></INPUT>
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

		                        <div class="bg-white text-center rounded-3" style = "padding-top: 10px; padding-bottom: 10px;">
		                            <img src = "Imagenes\logoIn.png" class = "img-fluid" style="max-height: 65px;">
		                        </div>
		                    </FORM>
		                </div>
		            </div>
				</div>
			</div>
        </div>
    </main>

    <footer>
    </footer>

    <!-- jquery -->
    <script src = "../Librerias/jquery.min.3.6.0.js"></script>
    <!-- tabs -->
    <script src = "../Librerias/tabs.bootstrap.js"></script>
    <!-- bootstrap -->
    <script src = "../Librerias/bootstrap.min.js"></script>
    
</body>
</html>