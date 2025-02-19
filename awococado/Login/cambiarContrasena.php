<?php
    require "../conexion.php";
    require "../funciones.php";
    
    $errors = "";
    $correct = "";
    $problemas = "";

	if (empty($_GET['idUsuario']) || empty($_GET['token'])){
		header ("Location: https://awococado.$hostName/");
	}

	@$id_usuario = $_GET['idUsuario'];
	@$token = $_GET['token'];

	if (!empty($_POST)){
	    $password = $_POST['password'];
	    $new_password = $_POST['passwordAgain'];

	    if (validaPassword($password, $new_password)){
			$resultado = cambiaPassword($password, $id_usuario, $token);
			if ($resultado == 1){
			    $correct = "La contraseña ha sido actualizada correctamente.";
			} else{
			    if ($resultado == 3){
			        $problemas = "Este enlace ya fue usado para cambiar su contraseña.";
			    } else{
			        $problemas = "Error al modificar la contraseña, inténtelo nuevamente más tarde.";
			    }
			}
		} else{
			$errors = "Las contraseñas no coinciden";
		}
	} else{
		if (!checkTokenPass($id_usuario, $token)){
	 		$problemas = "Este enlace ya ha caducado, regrese a iniciar sesión y vuelva a solicitar cambiar su contraseña.";
	 	}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambiar contraseña</title>
    <meta name charset="utf-8"/>
    <meta name="author" content="Annet Vargas Dueñas" />
    <meta name="viewport" content="width=device-width">

	<!-- Open Graph -->
    <meta property="og:title" content="Awococado: Business Web Application Demo" />
    <meta name="description" property="og:description" content="Awococado is a web application designed to optimize data capture, automate reporting, and provide business insights through statistical graphs and efficient document management." />
    <meta property="og:image" content="<?php echo $url_ogImage; ?>" />
    <meta property="og:site_name" content="annetvargas" />
    <meta property="og:url" content="https://<?php echo $hostName; ?>" />

    <!-- twitter card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Awococado: Business Web Application Demo">
    <meta name="twitter:description" content="Awococado is a web application designed to optimize data capture, automate reporting, and provide business insights through statistical graphs and efficient document management.">
    <meta name="twitter:image" content="<?php echo $url_ogImage; ?>">
    <meta property="og:url" content="https://<?php echo $hostName; ?>" />

	<!-- Docs styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    
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
    </script>

    <!--Cabecera-->
    <hearder>
    </hearder>

    <main>
        <div class = "container-fluid m-0 p-0">
            <div class="card col-12 border-0">
                <div class="" style="min-height: 600px; height: 100vh; padding-top: 10px; padding-left: 40px; background: white;">
                    <img src = "..\Imagenes\logoOficial.png" class = "img-fluid" style="max-height: 153px;">
                </div>
            </div>
            <div class="card-img-overlay m-0 p-0 text-center h-100" style="overflow: hidden;">
                <div class="row py-5 justify-content-center h-100 px-5">
                    <div class = "col-sm-12 col-md-12 bg-white my-auto" style="max-width: 500px; box-shadow: 0px 0px 20px rgba(0,0,0,.12);">
                        <FORM id = "formulario" NAME="formulario" method = 'POST' action = '<?php $_SERVER['PHP_SELF']?>'>
                            <div class="mt-2 border-0 px-0 px-sm-4">
                                <div class="text-center col-md-12 col-12 mt-5">
                                    <h4><strong>Cambiar contraseña</strong></h4>
                                </div>
                                <div class="text-center mt-4 px-4 px-sm-5">
                                    <p style = "font-size: .9rem;">Bienvenido al Sistema web AWOCOCADO, por favor complete todos los campos para cambiar su contraseña.</p>
                                </div>
                            </div>
                            <div class="card border-0 px-0 px-sm-4 rounded-4 mb-3">
                                <?php
                                    $pattern = "[A-Za-z0-9\._%+\-\(\)\[\]!$&'\*\/=\?\^`\{\}\|:;,~ñÑ#]+";
                                    $caracteres = "_%+-()[]!$&'*/=?^`{}|:;,~#.";
                                    if ($correct == ""){
                                        if ($problemas != ""){
                                            echo '<div class="row px-4 px-sm-5 pt-3 pb-0 mb-0 mt-0">
                                            <div class="px-4">
                                                <div style="background: #f3a292; height: 100px;" class = "p-1 row align-items-center">
                                                    <sapn id = "mensaje" class = "col-12 text-danger">'; echo $problemas; echo '</sapn>
                                                </div>
                                            </div>
                                        </div>';
                                        } else{
                                        	if ($errors == ""){
	                                            echo '<div class="row px-4 px-sm-5 pt-3 overflow-hidden pb-0">';
	                                        } else{
	                                            echo '<div class="row px-4 px-sm-5 pt-2 overflow-hidden pb-0">';
	                                        }

		                                        echo '<div class="input-group input-group-md mt-2 flex-nowrap">
		                                            <i class="bi bi-key-fill input-group-text" style = "padding-top: .45rem; color: #7eca28;"></i>
		                                            <INPUT name="password" id="password" type="password" placeholder="Nueva contraseña" class="form-control col-12" maxlength="20" minlength="8" aria-describedby="addon-wrapping" pattern="'.$pattern.'" autocomplete="off" title = "El formato no es válido. Solo se permiten los siguientes caracteres especiales: '.$caracteres.'" required></INPUT>
		                                        </div>
		                                        <div style = "height: 7px;"></div>

		                                        <div class="input-group input-group-md mt-2 flex-nowrap">
		                                            <i class="bi bi-key-fill input-group-text" style = "padding-top: .45rem; color: #7eca28;"></i>
		                                            <INPUT name="passwordAgain" id="passwordAgain" type="password" placeholder="Confirmar contraseña" class="form-control col-12" maxlength="20" minlength="8" aria-describedby="addon-wrapping" pattern="'.$pattern.'" autocomplete="off" title = "El formato no es válido. Solo se permiten los siguientes caracteres especiales: '.$caracteres.'" required></INPUT>
		                                        </div>';    

		                                            if ($errors == ""){
		                                                echo '<div class="col-12 my-2" style = "min-height: 15px;">';
		                                            } else{
		                                                echo '<div class="col-12 my-2" style = "font-size: .9rem; min-height: 23px;">';
		                                            }

		                                            echo '<span id = "mensaje" class = "text-danger">'; echo $errors; echo '</span>
		                                        </div>
		                                        <!-- submit -->
		                                        <div class="col-12">
		                                            <INPUT id = "enviarB" class = "btn-md btn col-12 rounded-1 text-white" style = "background: #7eca28;" TYPE="submit" VALUE="Cambiar contraseña" name = "enviarB" onClick="validar();"></INPUT>
		                                        </div>
		                                    </div>';
                                        }
                                    } else{
                                        echo '<div class="row px-4 px-sm-5 pt-3 pb-0 mb-0 mt-0">
                                            <div class="px-4">
                                                <div style="background: #d1ff9d; height: 100px;" class = "p-1 row align-items-center">
                                                    <sapn id = "mensaje" style = "color: #7eca28;" class = "col-12">'; echo $correct; echo '</sapn>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                ?>
                                <div class="text-muted px-4 px-sm-5 py-3 pt-0">
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <hr class="mt-2 mb-2 mt-4" />
                                        </div>

                                        <div class="col-12 text-center pb-3">
                                            <label class="form-label"><a class="link" href="..\">Regresar a iniciar sesión.</a></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </FORM>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
    </footer>

    <!-- jquery -->
    <script src = "../../libraries/jquery.min.3.6.0.js"></script>
    <!-- tabs -->
    <script src = "../../libraries/tabs.bootstrap.js"></script>
    <!-- bootstrap -->
    <script src = "../../libraries/bootstrap.min.js"></script>
    
</body>
</html>