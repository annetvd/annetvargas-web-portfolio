<?php
    require "../conexion.php";
    require "../funciones.php";

    $errors = "";
    $correct = "";
    $url = "../Login/templateRestPassword.php";
    $mensajeTem = "Recibimos una solicitud para restablecer la contraseña de tu cuenta, utiliza el enlace que se muestra o pulsa el botón de abajo.";
    $boton = "Restablecer contraseña";
    $seguridad = true;

    if (!empty($_POST)){
        $email = mysqli_real_escape_string($enlace, $_POST['email']);

        if (!isEmail($email)){
            $errors = "Debe ingresar un correo electrónico válido";
        }

        if (existeEmail($email)){
            $idUsuario = getValor('IdUsuario', 'Correo', $email);
            $nombre = getValor('Nombre', 'Correo', $email);

            $codigo = generateTokenPassword($idUsuario);

            if (sendEmail($email, $nombre, $codigo, $idUsuario, $url, $mensajeTem, $boton, $seguridad)){
                $correct = "Enviamos un correo a $email. Verifique su correo y siga las instrucciones que se le indican.";
            } else{
                $errors = "Error al enviar email.";
            }
        }else{
            $errors = "Este correo electrónico no está registrado";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Restablecer contraseña</title>
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
	<link rel="stylesheet" href="https://use.fontawesome.com/e2f7043252.css">
    
    <link rel="shortcut icon" href="..\Imagenes\icono.ico">

    <style type="text/css">
        a { color: #19221f; text-decoration: none;}
        a:hover { color: #7eca28; }
        .transparente { opacity:.5; }
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
                                    <h4><strong>Restablecer contraseña</strong></h4>
                                </div>
                                <div class="text-center mt-4 px-4 px-sm-5">
                                    <p style = "font-size: .9rem;">Bienvenido al sistema web AWOCOCADO. Por favor, ingrese su correo electrónico para restablecer la contraseña.</p>
                                </div>
                            </div>
                            <div class="card border-0 px-0 px-sm-4 rounded-4 mb-3">
                                <?php
                                    $caracteres = "_%+-()[]!$&'*/=?^`{}|:;,~#.";
                                    $pattern = "[A-Za-z0-9\._%+\-\(\)\[\]!$&'\*\/=\?\^`\{\}\|:;,~ñÑ#]+@[a-z0-9\.\-]+\.[a-z]{2,}$";
                                    if ($correct == ""){
                                        echo '<div class="row px-4 px-sm-5 pt-1 overflow-hidden pb-0">';

                                        echo '<div class="input-group input-group-md mt-2 flex-nowrap">
                                            <i class="fa fa-envelope icon input-group-text" style = "padding-top: .55rem; color: #7eca28;"></i>
                                            <INPUT id = "email" class = "form-control col-12" type = "email" maxlength="50" NAME="email" required placeholder="Correo electrónico" aria-describedby="addon-wrapping" pattern="'.$pattern.'" title="No se permiten caracteres fuera de: '.$caracteres.' Verifica que la dirección esté bien escrita."></INPUT>
                                        </div>';    

                                            if ($errors == ""){
                                                echo '<div class="col-12 my-1" style = "min-height: 15px;">';
                                            } else{
                                                echo '<div class="col-12 my-2" style = "font-size: .9rem; min-height: 23px;">';
                                            }

                                            echo '<sapn id = "mensaje" class = "text-danger">'; echo $errors; echo '</sapn>
                                        </div>
                                        <!-- submit -->
                                        <div class="col-12">
                                            <INPUT id = "enviarB" class = "btn-md btn col-12 rounded-1 text-white" style = "background: #7eca28;" TYPE="submit" VALUE="Enviar" name = "enviarB" onClick="validar();"></INPUT>
                                        </div>
                                    </div>';
                                    } else{
                                        echo '<div class="row px-4 px-sm-5 pt-2 pb-0 mb-0 mt-0">
                                            <div class="">
                                                <div style="background: #d1ff9d; padding-top: 10px; padding-bottom: 10px;" class = "px-3">
                                                    <span id = "mensaje" style = "color: #7eca28;">'; echo $correct; echo '</span>
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